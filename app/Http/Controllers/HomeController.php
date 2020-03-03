<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenStack\OpenStack;

class HomeController extends Controller
{

    protected $openstack;

    public function __construct(OpenStack\OpenStack $openstack)
    {
        $openstack = new OpenStack([
            'authUrl' => 'http://10.85.49.148:5000/v2.0',
             //'region'  => 'nova',
            'user'    => [
                'id'       => 'admin',
                'password' => 'ayZma3wpahjHWgpjBRQypFUYK'
            ],
            'scope'   => ['project' => ['id' => 'cpns']]
        ]);
    }
    
    public function index()
    {
        $openstack = $this->openstack;
        $compute = $openstack->computeV2(['region' => '{region}']);

        $servers = $compute->listServers(['imageId' => '{imageId}']);

        dd($servers);
    }

}
