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
            $this->middleware('auth');
            

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
                $flavors = $compute->listFlavors();
                
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
        var_dump($ipPool['nr_provider']);
        echo "=============================<br>";
        var_dump($ipPool['r_provider']);
        echo "=============================<br>";
       $totalIp1 = $this->openstack->listIpAddress('10.38.107.0',24,100);
       $totalIp2 = $this->openstack->listIpAddress('10.85.50.0',23,100);
        $nicIps = [];

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
      

    //   $nicIps = $totalIp1->each(function ($item, $key) use ($ipPool) {
    

    //         if(!in_array($item, $ipPool['r_provider'])){
                
    //             $new = $this->openstack->createIp($item,'10.85.50.0');
               
    //             if(!in_array($new, $ipPool['nr_provider'])){
    //                 return ['routeable'=> $item, 'non_routable' => $new];
                   
    //             }
                
    //         }
            
    //     });


       
    }

    

}
//creating OpenStack server: Bad request with: [POST http://10.85.49.148:8774/v2.1/os-volumes_boot], error message: {"badRequest": {"message": "Fixed IP address 10.85.50.177 is already in use on instance .", "code": 400}}[0m
//main.tf line 24, in resource "openstack_compute_instance_v2" "cpns": 24: resource "openstack_compute_instance_v2" "cpns" 