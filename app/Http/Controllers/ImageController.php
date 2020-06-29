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
use App\Ldap\User;



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

    public function allImages()
    {
        $images = Application::all();
        //dd($images);
        return view('allImage', ['images' => $images]);
        
    }



    public function store(Request $request)
    {
        $imageSplit = explode('?',$request->image);

        $chkImage = Application::where('uid',$imageSplit[0])->get();
        //dd($chkImage->toArray());

        if(count($chkImage)){

            return redirect()->route('addImage')->with('status', ' Image Already Exists');

        }else{
            $app = new Application;
            $app->name = $request->app;
            $app->uid  = $imageSplit['0'];
            $app->image  = $imageSplit['1'];
            $app->os = $request->os;
            $app->version = $request->version;
            if($app->save()){
                
                return redirect()->route('addImage')->with('status', $app->name.'-'.$app->os.' has been added successfully');
            }
        }

        // 0 = id , 1 = image name

        
    }

    public function storebyId(Request $request)
    {
        $servers = $this->openstack->defaultAuthentication();
        $apps = $servers->imagesV2();
        $image = $apps->getImage($request->image);
        dd($image);

        $chkImage = Application::where('uid',$request->image)->get();
        //dd($chkImage->toArray());

        if(count($chkImage)){

            return redirect()->route('addImage')->with('status', ' Image Already Exists');

        }else{
            $app = new Application;
            $app->name = $request->app;
            $app->uid  = $imageSplit['0'];
            $app->image  = $imageSplit['1'];
            $app->os = $request->os;
            $app->version = $request->version;
            if($app->save()){
                
                return redirect()->route('addImage')->with('status', $app->name.'-'.$app->os.' has been added successfully');
            }
        }

        // 0 = id , 1 = image name

        
    }

    public function destroy($id, Request $request)
    {
        $image = Application::find($id);
        $image->delete();
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
