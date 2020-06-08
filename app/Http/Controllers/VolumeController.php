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
        $servers = $this->openstack->defaultAuthentication();
        $service = $servers->blockStorageV2();
        // $snaps = $service->listSnapshots(false, [
        //     'volumeId'     => 'fdfd40de-1b7c-4291-85e5-9a7fe7f44890',
        // ]);
        $snaps = $service->listSnapshots();

        foreach ($snaps as $snap) {
          var_dump($snap);
          
        }
    }

    

}

