<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mail\VmLaunched;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Application;
use App\VM;
use Log;
use Auth;
use File;
use Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use OpenStack\OpenStack;
use App\Repository\OpenstackRepository;
use Illuminate\Support\Str;
use App\Ldap\User;
use App\Repository\IpaRepository;


class VmController extends Controller
{
    

    public function __construct(OpenstackRepository $openstack,IpaRepository $ipa ){

        $this->openstack = $openstack;
        $this->ipa = $ipa;
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
        $servers = $this->openstack->defaultAuthentication();
        $identity = $servers->identityV3(['domainId' => "default"]);
        $compute = $servers->computeV2();
        $flavors = $compute->listFlavors();
       

        //dd($allVM->toArray());
       
        return view('welcome',
        ['apps' => $apps, 
        'identity' => $identity, 'flavors' => $flavors]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->ipa->login('ch3484j');
        $otput = $this->ipa->findHost('arfi.cloud.vssi.com', 'ch3484j');
        $outArray = json_decode($otput, true);
        dd($outArray[0].result.count);
       
        $allVM = VM::with('application')->where('active',1)->get();
    
        return view('allVm',
        ['allVM' => $allVM]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * vssi_routable_subnet 10.38.64.0/22 
     * nr_provider_subnet 10.85.50.0/23 
     * r_subnet 10.38.107.0/24  
     */

    public function store(Request $request)
    {
        //dd($request->toArray());
        ini_set('max_execution_time', 3600);
        ob_implicit_flush(true);
        ob_implicit_flush();
        set_time_limit(0);
       // $script_source = public_path('startup.sh');
        $script_source = public_path();
        $private_key = public_path('include/vdf-key1.pem');
        $username = "";

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

        if($request){
            
            echo "Fetching all the ips from openstack <br>";
            ob_flush();
            flush();

            $totalNrIp = $this->openstack->listIpAddress('10.85.50.0','23',55);
            $totalRproviderIP = $this->openstack->listIpAddress('10.38.107.0','24',55);
            $totalVssiIP = $this->openstack->listIpAddress('10.38.64.0','22',55);

            $servers = $this->openstack->defaultAuthentication();
            $identity = $servers->identityV3(['domainId' => "default"]);

            echo "This may take some time... Please donot refresh the page <br>";
            ob_flush();
            flush();
            echo "Searching.";
            foreach ($identity->listProjects(['domainId' => "default"]) as $project) {
                echo "...";
                ob_flush();
                flush();

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
                                    array_push($ipPool['nr_provider'], $ipValue[0]['addr']); //50.85
                                    
                                }
                
                                if($ipKey === 'r_provider'){
                                    array_push($ipPool['r_provider'], $ipValue[0]['addr']); //107
                                    
                                }
                            }                              
                            
                        }
                
                    }
                    
                }
                
            }
            //dd($ipPool);
            echo "<br>";
            echo "Comparing possible ips......<br>";
            ob_flush();
            flush();

            foreach($totalNrIp as $key => $value)
            {
                if(!in_array($value, $ipPool['nr_provider'])){
                    
                    $explodeIp = explode('.',$value);

                    if($explodeIp['2'] == '51'){
                        $new = $this->openstack->createIp($value,'10.38.64.0');
                        if(!in_array($new, $ipPool['vssi_routable'])){
                            $nicIps = ['routeable'=> $new, 'non_routable' => $value , 'netName' => 'vssi_routable'];
                            break;
                        }

                    }
                    if($explodeIp['2'] == '50'){
                        $new = $this->openstack->createIp($value,'10.38.107.0');
                        if(!in_array($new, $ipPool['r_provider'])){
                            $nicIps = ['routeable'=> $new, 'non_routable' => $value, 'netName' => 'r_provider'];
                            break;
                        }
                    }

                    
                }
            }
          
            echo "</br>";
            echo "============================================================= <br>";
            echo  "<b style='color:#08c31c'>NIC 1 === ".$nicIps['non_routable']."</b><br>";
            echo  "<b style='color:#08c31c'>NIC 2 === ".$nicIps['routeable']."</b><br>";
            echo "============================================================= <br>";

            //dd('End');
           
            $dir = $request->vmname.'-'.uniqid();
            
            $path = storage_path('app/'.$dir);
            $randomPass = Str::random(6);
            $checkUser = User::where('mail', '=', $request->email)->first();
            $cookieName = Str::random(16);
            $this->ipa->login($cookieName);

            if ($checkUser){
                $username = $checkUser->uid[0];
                echo  "<b style='color:#08c31c'>".$username." already exist</b><br>";
            }else{

                $username = $this->openstack->createUsername($request);
               
                $this->ipa->addUser($username,$request->firstName,$request->lastName,$randomPass, $cookieName);
                echo  "<b style='color:#08c31c'>".$username." USER CREATED</b><br>";
            }
            
            $hostname = $this->openstack->createHostname($username);

            $template = public_path('template/template.tf');

            $app = Application::find($request->app);
            $pluginPath = public_path('plugin');
             
            //terraform apply -var="nic1=10.85.50.130" -var="nic2=10.38.107.130" -var="vmname=inapou06.cloud.vssi.com" -var="app=apix" -var="emailid=hiral.ajitbhaijethva@vodafone.com|flav_8c_16m"

            $command = 'terraform12 apply -auto-approve  -input=false -var="project='.$request->project.'" -var="nic1='.$nicIps['non_routable'].'" -var="nic2='.$nicIps['routeable'].'" -var="netname='.$nicIps['netName'].'" -var="vmname='.$request->vmname.'" -var="app='.$app->uid.'" -var="flavor='.$request->flavor.'" -var="script_source='.$script_source.'" -var="private_key='.$private_key.'" -var="hostname='.$hostname.'"   -var="emailid='.$request->email.'"';

            if(!File::isDirectory($path)){

                File::makeDirectory($path, 0777, true, true);
                File::copy($template, $path.'/main.tf');
              
                //Log::useFiles($path.'/output.log');
                
                $init = 'terraform12 init  -input=false -plugin-dir='.$pluginPath.'';
                $process = new Process($init);
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

                            $nicIps = ['routeable'=> $value, 'non_routable' => $new];
                            $newvm = New VM;
                            $newvm->application_id = $request->app;
                            $newvm->dir = $dir;
                            $newvm->name = $request->vmname;
                            $newvm->firstname = $request->firstName;
                            $newvm->lastname = $request->lastName;
                            $newvm->username = $username;
                            $newvm->hostname = $hostname;
                            $newvm->email = $request->email;
                            $newvm->pass = $randomPass;
                            $newvm->project = $request->project;
                            $newvm->flavor = $request->flavor;
                            $newvm->nic1 = $nicIps['routeable'];
                            $newvm->nic2 = $nicIps['non_routable'];
                            $newvm->created_by = Auth::user()->name;
                            $newvm->active = 1;
                            if($newvm->save()){
                                //rule = username
                                $this->ipa->addHbacRule($username, $cookieName);
                                $this->ipa->addHbacRuleUser($username,$username, $cookieName);
                                $this->ipa->addHbacRuleHost($username,$hostname, $cookieName);
                                $this->ipa->addHbacRuleService($username, $cookieName);

                                Log::info($request->vmname.'- VM created');
                                Mail::to($newvm->email)->send(new VmLaunched($newvm));
                               // Mail::to('mahesh.pawar@vodafone.com')->cc('dcops-cloud-vssi@vodafone.com')->send(new IpUpdateNotification($newvm));

                                echo "</br><br>";
                                echo "<span style='color:#20ff00'>";
                                echo "======================================================= <br>";
                                echo "======".$request->vmname."- VM Created Successfully ===== <br>";
                                echo  "<b style='color:#20ff00'>Username === ".$username."</b><br>";
                                echo  "<b style='color:#20ff00'>Password === ".$randomPass."</b><br>";
                                echo  "<b style='color:#20ff00'>Hostname === ".$hostname."</b><br>";
                                echo  "<b style='color:#20ff00'>NIC 1 === ".$nicIps['non_routable']."</b><br>";
                                echo  "<b style='color:#20ff00'>NIC 2 === ".$nicIps['routeable']."</b><br>";
                                echo "=======================================================<br>";
                                echo "</span>";
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
        $path = storage_path('app/'.$deleteVM->dir);
        $process = new Process('terraform12 destroy -var="project='.$deleteVM->project.'" -auto-approve');
        //$process = new Process('ping -c 50 www.google.com');
        $process->setTimeout(3600);
        $process->setWorkingDirectory($path);
        $process->run();
        Log::debug($process->getOutput()); 
        if ($process->isSuccessful()) {
            $deleteVM->active = 0;
            if($deleteVM->save()){
                $cookieName = 'del-'.$deleteVM->name;
                $this->ipa->login($cookieName);
               // $this->ipa->deleteUser($deleteVM->username, $cookieName);
                $this->ipa->deleteHost($deleteVM->hostname, $cookieName);
                $this->ipa->deletePolicy($deleteVM->username, $cookieName);
                Log::info($deleteVM->vmname.'- VM deleted');
                return $deleteVM->id;
            }
        }


        
    }
}
