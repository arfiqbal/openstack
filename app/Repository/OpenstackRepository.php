<?php

namespace App\Repository;

use OpenStack\OpenStack;
use Illuminate\Support\Collection;
use IPv4\SubnetCalculator;
use App\VM;
use App\Application;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


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

    public function listIpAddressSlice($ip_range,$subnet,$removePrefix = 0,$removePost = 0)
    {
        $list = [];
        $sub = new SubnetCalculator($ip_range, $subnet);
            foreach($sub->getAllHostIPAddresses() as $ip){
                array_push($list,$ip);
            }
        $collection = collect($list);
        $slice = $collection->slice($removePrefix,$removePost);
        return $slice->all();
        //$slice = $collection->slice(30,-24);

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
        $appString = substr($app->name,0,3);
        $openstk = 'o';
        $os = strtolower(substr($app->os,0,1));
        
        $host = "in".$appString.''.$openstk.''.$os;

        return $host;
    }

    public function createHostname($hostString, $appid)
    {  
        $actualHostCount = 0;
        $vmHostCount = VM::where('hostname_code',$hostString)->orderBy('id', 'DESC')->first();
        if($vmHostCount){
            preg_match_all('!\d+!', $vmHostCount->hostname, $matches);
            $flattened = Arr::flatten($matches);
            $hostCount = $flattened[0] + 1 ;
        }else{
            $hostCount = 1;
        }
       
        
        if($hostCount <= 9){
            $actualHostCount =  '0'.$hostCount;
        }else{
            $actualHostCount =  $hostCount;
        }
        $newHostname = $hostString.''.$actualHostCount.'.cloud.vssi.com';

        return strtolower($newHostname);
    }



    public function oldcreateHostname($hostString, $appid)
    {  
        $vmHostCount = VM::where('hostname_code',$hostString)->orderBy('id', 'DESC')->first();
        dd($vmHostCount->toArray());
        // in<appname><openstack><os><no>
        //initial_count
        $app = Application::find($appid);
        
        //$vmHostCount = VM::where('hostname_code',$hostString)->where('active',1)->count() + 1;
        $vmHostCount = VM::where('hostname_code',$hostString)->count();
        // $vmHostCount = VM::where('hostname_code',$hostString)->count() + 1;
      
        $hostCount = $app->initial_count + $vmHostCount;
        $actualHostCount = 0;
        if($hostCount <= 9){
            $actualHostCount =  '0'.$hostCount;
        }else{
            $actualHostCount =  $hostCount;
        }
        $newHostname = $hostString.''.$actualHostCount.'.cloud.vssi.com';
        return strtolower($newHostname);
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
    public function findReTemplate($appid)
    {
        $app = Application::find($appid);
        if($app->os == 'ubuntu'){
            return public_path('template/reTemplateUbuntu.tf');
        }elseif($app->os == 'centos'){
            return public_path('template/reTemplateCentos.tf');
        }elseif($app->os == 'window'){
            return public_path('template/reTemplateWindow.tf');
        }elseif($app->os == 'rhel'){
            return public_path('template/reTemplateRhel.tf');
        }else{
            return public_path('template/reTemplateUbuntu.tf');
        }

            
    }
    

    public function getFlavorDetail($flavor)
    {
        $servers = $this->defaultAuthentication();
        $compute = $servers->computeV2();
        $flavor = $compute->getFlavor(['id' => $flavor]);
        $flavor->retrieve();
        $ram = $flavor->ram/1024;
        //return "RAM = '.$ram.GB'  vCPU ='.$flavor->vcpus";
        return "RAM = ".$ram." GB, vCPU = ".$flavor->vcpus;
        
    }

    public function getSize($projectID,$imageID)
    {
        if($projectID == '198f0660ae894f87a5ad2522e6dec551' || $projectID == '2bdf7fd40d044e8c9ad23d7501d2f055')
        {
            $size = 260;
        }else{
        $servers = $this->defaultAuthentication();
        $service = $servers->imagesV2();
        $image = $service->getImage($imageID);
        $image->retrieve();
        $size2 = $image->size/1024;
        $size1 = $size2/1024;
        $newsize = $size1/1024;
        $size =   $newsize + 5;
        }
        return  $size;
    }

    public function stopDeleteServer(VM $vm)
    {
        $openstackServer = $this->openstackProjectID($vm->project);
        $compute = $openstackServer->computeV2();
        $server = $compute->getServer(['id' => $vm->vm_uid]);
        
        $server->stop();
        $this->delay(15);
        $server->delete();
        $this->delay(10);
    }

    public function deleteVolume($vm){
        $servers = $this->openstackProjectID($vm->project);
        $service = $servers->blockStorageV2();

        $volume = $service->getVolume($vm->vol);
        $volume->delete();
        
    }

    public function changeServerFlavor($vmuid,$flavor)
    {
        $vm = VM::with('application')->find($vmuid);
       
        $servers = $this->defaultAuthentication();
        $compute = $servers->computeV2();
        $server = $compute->getServer([
            'id' => $vm->vm_uid,
        ]);
        
        $server->resize($flavor);
        $i = 0;
        while(1){
           if($i == 40){
           break;
           }
           sleep(1);
            $i++;

        }
        if($server->confirmResize()){
            $vm = VM::find($vmuid);
            $vm->flavor = $flavor;
            $vm->save();
        }

        

        
    }

    private function delay($time = 10)
    {
        $i = 0;
        while(1){
           if($i == $time){
           break;
           }
           sleep(1);
            $i++;

        }
    }
}
