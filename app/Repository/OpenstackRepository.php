<?php

namespace App\Repository;

use OpenStack\OpenStack;
use Illuminate\Support\Collection;
use IPv4\SubnetCalculator;
use App\VM;
use App\Application;
use Illuminate\Support\Str;


class OpenstackRepository
{
    // public function __construct(){

    // }


    public function listIpAddress($ip_range,$subnet,$remove = 0)
    {
        $list = [];
        $sub = new SubnetCalculator($ip_range, $subnet);
            foreach($sub->getAllHostIPAddresses() as $ip){
                array_push($list,$ip);
            }
        $collection = collect($list);
        $slice = $collection->slice($remove);
        return $slice->all();


    }

    public function findIpAddress($ip, Array $listOfIpAddress){
        if(is_array($listOfIpAddress))
        {
            $collection = collect($listOfIpAddress);
            if($collection->has($ip) == false){
                return "not find";
            }

            return $ip;
        }

        return "not array";
    }

    public function createIp($ipAddress,$subnet)
    {   
        $explodeIp = explode('.',$ipAddress);
        $explodeSubnet = explode('.',$subnet);

        $newIP = $explodeSubnet['0'].".".$explodeSubnet['1'].".".$explodeSubnet['2'].".".$explodeIp['3'];
        return $newIP;
    }

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


    public function createUsername($request)
    {
        $name =  Str::words($request->firstName, 1, '');
        $username = $name."".$request->lastName[0];
        $i = 0;
        while (VM::where('username', $username)->exists()) {
            $i++;
            $username = $name."".$request->lastName[0]."".$i;

        }
        return strtolower($username);     

    }

    public function createHoststring($appid)
    {  
        // in<appname><openstack><os><no>
        $app = Application::find($appid);
        $appString = substr($app->name,0,7);
        $openstk = 'o';
        $os = strtolower(substr($app->os,0,1));
        
        $host = "in".$appString.''.$openstk.''.$os;

        return $host;
    }
    public function createHostname($hostString)
    {  
        // in<appname><openstack><os><no>
        $vmHostCount = VM::where('hostname_code',$hostString)->count() + 1;

        return $hostString.''.$vmHostCount.'.cloud.vssi.com';
    }

    public function lastVm()
    {
        return VM::with('application')->orderBy('id', 'DESC')->first();
    }

    public function findTemplate($appid)
    {
        $app = Application::find($appid);
        if($app->os == 'ubuntu'){
            return public_path('template/templateUbuntu.tf');
        }elseif($app->os == 'centos'){
            return public_path('template/templateCentos.tf');
        }elseif($app->os == 'window'){
            return public_path('template/templateWindow.tf');
        }elseif($app->os == 'rhel'){
            return public_path('template/templateRhel.tf');
        }else{
            return public_path('template/templateUbuntu.tf');
        }

            
    }
    
}
