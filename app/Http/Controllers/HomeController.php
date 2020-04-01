<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenStack\OpenStack;
use  App\Repository\OpenstackRepository;


class HomeController extends Controller
{
    protected $openstack;

	public function __construct(OpenstackRepository $openstack){

            $this->openstack = $openstack;
            // $this->middleware('auth');
            

    }

    
    
    public function store1(Request $request)
    {
        //dd($request->toArray());
       
                            $username = $this->openstack->createUsername($request);

                            $nicIps = ['routeable'=> '192.168.1.2', 'non_routable' => '192.168.1.3'];
                            $newvm = New VM;
                            $newvm->application_id = $request->app;
                            $newvm->dir = '/dir';
                            $newvm->name = $request->vmname;
                            $newvm->firstname = $request->firstName;
                            $newvm->lastname = $request->lastName;
                            $newvm->username = $username;
                            $newvm->email = $request->email;
                            $newvm->project = $request->project;
                            $newvm->flavor = $request->flavor;
                            $newvm->nic1 = $nicIps['routeable'];
                            $newvm->nic2 = $nicIps['non_routable'];
                            $newvm->created_by = Auth::user()->name;
                            $newvm->active = 1;
                            $newvm->save();


         
    }

    public function store(Request $request)
    {
        //dd($request->toArray());
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
        
            foreach ($identity->listProjects(['domainId' => "default"]) as $project) {
                echo ".";
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
            echo  "NIC 1 === ".$nicIps['non_routable']."<br>";
            echo  "NIC 2 === ".$nicIps['routeable']."<br>";
            echo "============================================================= <br>";

            //dd('End');
           
            $dir = $request->vmname.'-'.uniqid();
            

            $path = storage_path('app/'.$dir);
            

            $template = public_path('template/template.tf');

            $app = Application::find($request->app);
            $pluginPath = public_path('plugin');
             
            //terraform apply -var="nic1=10.85.50.130" -var="nic2=10.38.107.130" -var="vmname=inapou06.cloud.vssi.com" -var="app=apix" -var="emailid=hiral.ajitbhaijethva@vodafone.com|flav_8c_16m"

            $command = 'terraform12 apply -auto-approve -var="project='.$request->project.'" -var="nic1='.$nicIps['non_routable'].'" -var="nic2='.$nicIps['routeable'].'" -var="netname='.$nicIps['netName'].'" -var="vmname='.$request->vmname.'" -var="app='.$app->uid.'" -var="flavor='.$request->flavor.'" -var="emailid='.$request->email.'"';

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

                            $username = $this->openstack->createUsername($request);

                            $nicIps = ['routeable'=> $value, 'non_routable' => $new];
                            $newvm = New VM;
                            $newvm->application_id = $request->app;
                            $newvm->dir = $dir;
                            $newvm->name = $request->vmname;
                            $newvm->firstname = $request->firstName;
                            $newvm->lastname = $request->lastName;
                            $newvm->username = $username;
                            $newvm->email = $request->email;
                            $newvm->project = $request->project;
                            $newvm->flavor = $request->flavor;
                            $newvm->nic1 = $nicIps['routeable'];
                            $newvm->nic2 = $nicIps['non_routable'];
                            $newvm->created_by = Auth::user()->name;
                            $newvm->active = 1;
                            if($newvm->save()){

                               
                                Log::info($request->vmname.'- VM created');

                                echo "</br><br>";
                                echo "======================================================= <br>";
                                echo "====".$request->vmname."- VM created successfully ===== <br>";
                                echo "=======================================================<br>";
                            }

                        }

                    
                
                }else{
                        //throw new ProcessFailedException($process);
                        
                    }

                


            }
        }
    }
    
}
//"directorytree/ldaprecord-laravel": "^1.0",