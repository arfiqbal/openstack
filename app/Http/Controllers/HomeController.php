<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenStack\OpenStack;


class HomeController extends Controller
{

    
    public function index()
    {
        $openstack_server = new OpenStack([
            'authUrl' => 'http://10.85.49.148:5000/v2.0',
             'region'  => 'nova',
            'user'    => [
                'id'       => 'admin',
                'password' => 'ayZma3wpahjHWgpjBRQypFUYK'
            ],
            'scope'   => ['project' => ['id' => '4d9031e2761c482e873ee7fcdf73ba29']]
        ]);
        $compute = $openstack_server->computeV2();

        $servers = $compute->listServers();

        dd($servers);
    }

}
