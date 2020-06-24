<?php

namespace App\Repository;

use OpenStack\OpenStack;
use Illuminate\Support\Collection;
use IPv4\SubnetCalculator;
use App\VM;
use App\Application;
use Illuminate\Support\Str;


class VolumeRepository
{
    // public function __construct(){

    // }

    public function openstackProjectID($project_id)
    {
        //'scope'   => ['project' => ['id' => '4d9031e2761c482e873ee7fcdf73ba29']]
        $openstack_server = new OpenStack([
            'authUrl' => 'http://10.85.49.148:5000/v3/',
            'region'  => 'regionOne',
            'user'    => [
                'id'       => 'd348fcb1b1994c3ea5c7cea8c00a770a',
                'password' => 'ayZma3wpahjHWgpjBRQypFUYK',
                'domain' => ['name' => "default"]
            ],
            'scope'   => ['project' => ['id' => $project_id]]
        ]);

        return $openstack_server;
    }

    public function defaultAuthentication()
    {
        //'scope'   => ['project' => ['id' => '4d9031e2761c482e873ee7fcdf73ba29']]
        $openstack_server = new OpenStack([
            'authUrl' => 'http://10.85.49.148:5000/v3/',
            'region'  => 'regionOne',
            'user'    => [
                'id'       => 'd348fcb1b1994c3ea5c7cea8c00a770a',
                'password' => 'ayZma3wpahjHWgpjBRQypFUYK',
                'domain' => ['name' => "default"]
            ],
            'scope'   => ['project' => ['id' => '4d9031e2761c482e873ee7fcdf73ba29']]
        ]);

        return $openstack_server;
    }

    public function listSnapshot($project_id, $volume)
    {   
        $list = [];
        $servers = $this->openstackProjectID($project_id);
        $service = $servers->blockStorageV2();
        $snaps = $service->listSnapshots(true);
        foreach ($snaps as $snap) {
            if($value == $snap->volumeId){
                array_push($list, [$snap->volumeId => $snap->id]);
            }
            
        }

        return $list;
    }


}
