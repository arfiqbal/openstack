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

        // foreach ($apps as $app) {
        //     var_dump($app);
        // }
        // dd('s');
        return view('appImage', ['apps' => $apps]);
        
    }



    public function store(Request $request)
    {
        $app = new Application;
        $app->name = $request->app;
        $app->uid  = $request->image;
        $app->os = $request->os;
        if($app->save()){
            return redirect()->route('addImage');
        }
    }

    // public function pdf()
    // {
    //     $previous_week = strtotime("-1 week +1 day");
    //     $start_week = strtotime("last sunday midnight",$previous_week);
    //     $end_week = strtotime("next saturday",$start_week);
    //     $start_week = date("Y-m-d h:m:s",$start_week);
    //     $end_week = date("Y-m-d  h:m:s",$end_week);
    //     //$newvm = VM::whereBetween('created_at', [$start_week,$end_week])->get();
    //     $newvm = VM::get();
    //     return view('generatePDF', ['newvm' => $newvm]);
    // }
    
}
