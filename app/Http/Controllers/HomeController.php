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
            

	}
    
    public function index()
    {
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

        dd($ipPool);
        
    }

    public function refFunctionDelete()
    {
        
        $ips = $this->openstack->createIp('10.85.50.115','10.209.100.0');
        dd($ips);
        dd($this->openstack->findIpAddress('10.85.50.104',$ips));
        dd($ips);

        // $openstack_server = new OpenStack([
        //     'authUrl' => 'http://10.85.49.148:5000/v2.0',
        //      'region'  => 'nova',
        //     'user'    => [
        //         'id'       => 'admin',
        //         'password' => 'ayZma3wpahjHWgpjBRQypFUYK'
        //     ],
        //     'scope'   => ['project' => ['id' => '4d9031e2761c482e873ee7fcdf73ba29']]
        // ]);
        // $compute = $openstack_server->computeV2();

        // $servers = $compute->listServers();

        // dd($servers);
    }

    

}
