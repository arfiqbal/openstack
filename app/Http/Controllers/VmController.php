<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use App\Network;
use App\Network1;
use App\VM;
use Log;
use File;
use Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use OpenStack\OpenStack;
use  App\Repository\OpenstackRepository;


class VmController extends Controller
{

    public function __construct(OpenstackRepository $openstack){

        $this->openstack = $openstack;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = Application::orderBy('id','DESC')->get();
        $networks = Network::all();
        $network1s = Network1::first();
        $servers = $this->openstack->defaultAuthentication();
        $identity = $servers->identityV3(['domainId' => "default"]);
       

        //dd($allVM->toArray());
       
        return view('welcome',
        ['apps' => $apps,'networks' => $networks, 'network1s' => $network1s, 
        'identity' => $identity]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->toArray());
        ini_set('max_execution_time', 3600);
        ob_implicit_flush(true);
        ob_implicit_flush();
        set_time_limit(0);
        $ids = ['7200d61d8cc545aeb2e4bc28e29f3a2d',
                '9a08dfd7eecc494a9ba750e5f86da626',
                'b9156dd5582e46b68ace7d74e201968d',
                'bb6617e566f2477ea09f6962207cff32',
                'd6d0a6ab1c904199935f950f2c58de8d',
                'fe9633e0641e4fb995aa64dd161b6c55'
            ];
        $ipPool['vssi_routable'] = array();
        $ipPool['nr_provider'] = array();
        $ipPool['r_provider'] = array();
        $nicIps = [];

        $routable_networ = Network::find($request->id);

        if(count($request)){

            $routable_network = Network::find($request->network);
            $non_routable_network = Network1::find($request->network1);

            $totalIp1 = $this->openstack->listIpAddress($routable_network->network,$routable_network->subnet,100);
            $totalIp2 = $this->openstack->listIpAddress($non_routable_network->network,$routable_network->subnet,100);

            $servers = $this->openstack->defaultAuthentication();
            $identity = $servers->identityV3(['domainId' => "default"]);
        
            foreach ($identity->listProjects(['domainId' => "default"]) as $project) {
                

                if(!in_array($project->id, $ids)){

                    $projectsServer = $this->openstack->openstackProjectID($project->id);
                    $compute = $projectsServer->computeV2();
                    $serverslist = $compute->listServers();
                    
                    foreach($serverslist as $server){

                        if($server){
                            foreach($server->listAddresses() as $ipKey => $ipValue){
                            
                                if($ipKey === 'vssi_routable'){
                                    array_push($ipPool['vssi_routable'], $ipValue[0]['addr']);
                                    
                                }
                
                                if($ipKey === 'nr_provider'){
                                    array_push($ipPool['nr_provider'], $ipValue[0]['addr']);
                                    
                                }
                
                                if($ipKey === 'r_provider'){
                                    array_push($ipPool['r_provider'], $ipValue[0]['addr']);
                                    
                                }
                            }  
                            
                            
                        }
                
                    }

                    
                }

                
            }

            foreach($totalIp1 as $key => $value)
            {
                if(!in_array($value, $ipPool['r_provider'])){
                    
                    $new = $this->openstack->createIp($value,'10.85.50.0');
                
                    if(!in_array($new, $ipPool['nr_provider'])){
                        $nicIps = ['routeable'=> $value, 'non_routable' => $new];
                    break;
                    }
                    
                }
            }


            $dir = $request->vmname.'-'.uniqid();
            

            $path = storage_path('app/'.$dir);
            

            $template = public_path('template/template.tf');

            $app = Application::find($request->app);
             

            $command = 'terraform12 apply -auto-approve -var="nic1='.$request->nic1.'" -var="nic2='.$request->nic2.'" -var="vmname='.$request->vmname.'" -var="app='.$app->uid.'" -var="emailid='.$request->email.'"';

            if(!File::isDirectory($path)){

                File::makeDirectory($path, 0777, true, true);
                File::copy($template, $path.'/main.tf');
                Log::useFiles($path.'/output.log');

                $process = new Process('terraform12 init -input=false');
                $process->setTimeout(3600);
                $process->setWorkingDirectory($path);
                $process->run(function ($type, $buffer) {
    
                    if (Process::ERR === $type) {
                        
                        
                        echo $buffer."<br>";
                        ob_flush();
                        flush();
                         
                    } else {
                        
                        echo $buffer."<br>";
                        ob_flush();
                        flush();
                         
                    }
               
                });
                Log::debug($process->getOutput());
                if ($process->isSuccessful()) {

                    $process->setCommandLine($command);
                    $process->run(function ($type, $buffer) {
    
                    if (Process::ERR === $type) {
                        
                        
                        echo $buffer."<br>";
                        ob_flush();
                        flush();
                         
                    } else {
                        
                        echo $buffer."<br>";
                        ob_flush();
                        flush();
                         
                    }
               
                });
                    Log::debug($process->getOutput()); 

                        if (!$process->isSuccessful()) {
                            
                            Log::critical($process->getOutput());
                            // throw new ProcessFailedException($process);
                        }else{

                            $newvm = New VM;
                            $newvm->ip_id = $request->ip_id;
                            $newvm->application_id = $request->app;
                            $newvm->dir = $dir;
                            $newvm->name = $request->vmname;
                            $newvm->email = $request->email;
                            $newvm->active = 1;
                            if($newvm->save()){

                                $updateip = IPs::find($newvm->ip_id);
                                $updateip->active = 0;
                                $updateip->save(); 

                                
                                Log::info($request->vmname.'- VM created');

                                echo "</br><br>";
                                echo "======================================================= <br>";
                                echo "====".$request->vmname."- VM created successfully =====";
                                echo "=======================================================<br>";
                            }

                        }

                    
                
                }else{
                        //throw new ProcessFailedException($process);
                        
                    }

                


            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        $showVmLogs = VM::find($request->id);
        $path = storage_path('app/'.$showVmLogs->dir.'/output.log');
        return File::get($path);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteVM = VM::find($id);
        //dd($deleteVM->toArray());
        // $deleteVM->active = 0;
        //     if($deleteVM->save()){
        //         return $deleteVM->id;
        //     }

        $path = storage_path('app/'.$deleteVM->dir);
        $process = new Process('terraform12 destroy -auto-approve');
        //$process = new Process('ping -c 50 www.google.com');
        $process->setTimeout(3600);
        $process->setWorkingDirectory($path);
        $process->run();
        Log::debug($process->getOutput()); 
        if ($process->isSuccessful()) {
            $deleteVM->active = 0;
            if($deleteVM->save()){
                $releaseIP = IPs::find($deleteVM->ip_id);
                $releaseIP->active = 1;
                $releaseIP->save();
            
                Log::info($deleteVM->vmname.'- VM deleted');
                return $deleteVM->id;
            }
        }


        
    }
}
