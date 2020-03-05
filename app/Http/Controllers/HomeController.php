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
       
        $servers = $this->openstack->defaultAuthentication();
        $identity = $servers->identityV3(['domainId' => "default"]);
        $a = 0;
        foreach ($identity->listProjects(['domainId' => "default"]) as $project) {
            echo $project->id."<br>";
            $projectsServer = $this->openstack->openstackProjectID($project->id);
            $compute = $projectsServer->computeV2();

            $serverslist = $compute->listServers();

            foreach ($serverslist as $server) {
                $a++;
            }

            echo $project->name."=====================".$a."<br>";

            $a = 0;
        }
        
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
