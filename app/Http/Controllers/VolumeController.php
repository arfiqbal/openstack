<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;

use App\Rework;
use App\VM;
use Auth;
use OpenStack\OpenStack;
use App\Repository\VolumeRepository;


class VolumeController extends Controller
{
    

    public function __construct(VolumeRepository $openstack ){

        $this->openstack = $openstack;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = $this->openstack->openstackProjectID('198f0660ae894f87a5ad2522e6dec551');
        $service = $servers->blockStorageV2();
        $snaps = $service->listSnapshots(true,[
            'volumeId'     => 'dfb43258-283e-4245-8658-c39fc5782cdd'
        ]);

        // $snaps = $service->getVolume('dfb43258-283e-4245-8658-c39fc5782cdd');
        // $snaps->retrieve();
        // dd($snaps);
        //$snaps = $service->listSnapshots();

        foreach ($snaps as $snap) {
          dd($snap);
          
        }
    }

    

}

