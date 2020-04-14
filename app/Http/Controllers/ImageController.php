<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mail\VmLaunched;
use App\Mail\IpUpdateNotification;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Application;
use App\VM;
use Log;
use Auth;
use File;
use Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use OpenStack\OpenStack;
use App\Repository\OpenstackRepository;
use Illuminate\Support\Str;



class ImageController extends Controller
{
    

    public function __construct(OpenstackRepository $openstack ){

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
        $apps = $servers->imagesV2()->listImages();

        
        return view('appImage', ['apps' => $apps]);
        
    }



    public function store(Request $request)
    {
        
    }

    
}
