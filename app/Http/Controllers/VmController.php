<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Application;
use App\IPs;
use App\VM;
use Log;
use File;
use Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class VmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = Application::orderBy('id','DESC')->get();
        $ips  = IPs::orderBy('id','ASC')->where('active',1)->first();
        $available_ips  = IPs::orderBy('id','ASC')->where('active',1)->get();
        $allVM = VM::with('application','ips')->orderBy('id','DESC')->where('active',1)->get();

        //dd($allVM->toArray());
       
        return view('welcome',['apps' => $apps,'ips' => $ips, 'available_ips' => $available_ips,'allVM' => $allVM]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ini_set('max_execution_time', 3600);
        ob_implicit_flush(true);
        ob_implicit_flush();
        set_time_limit(0);
        

        if(count($request)){

            $dir = $request->vmname.'-'.uniqid();
            //$dir = $request->vmname;

            $path = storage_path('app/'.$dir);
            

            $template = public_path('template/template.tf');

            $app = Application::find($request->app);
             

            // dd($template);

            $command = 'terraform12 apply -auto-approve -var="nic1='.$request->nic1.'" -var="nic2='.$request->nic2.'" -var="vmname='.$request->vmname.'" -var="app='.$app->uid.'" -var="emailid='.$request->email.'"';

            if(!File::isDirectory($path)){

                File::makeDirectory($path, 0777, true, true);
                File::copy($template, $path.'/main.tf');
                Log::useFiles($path.'/output.log');

                $process = new Process('terraform12 init -input=false');
                $process->setTimeout(3600);
                $process->setWorkingDirectory($path);
                $process->run(function ($type, $buffer) {
    
                    if (Process::ERR === $type) {
                        
                        
                        echo $buffer."<br>";
                        ob_flush();
                        flush();
                         
                    } else {
                        
                        echo $buffer."<br>";
                        ob_flush();
                        flush();
                         
                    }
               
                });
                Log::debug($process->getOutput());
                if ($process->isSuccessful()) {

                    $process->setCommandLine($command);
                    $process->run(function ($type, $buffer) {
    
                    if (Process::ERR === $type) {
                        
                        
                        echo $buffer."<br>";
                        ob_flush();
                        flush();
                         
                    } else {
                        
                        echo $buffer."<br>";
                        ob_flush();
                        flush();
                         
                    }
               
                });
                    Log::debug($process->getOutput()); 

                        if (!$process->isSuccessful()) {
                            
                            Log::critical($process->getOutput());
                            // throw new ProcessFailedException($process);
                        }else{

                            $newvm = New VM;
                            $newvm->ip_id = $request->ip_id;
                            $newvm->application_id = $request->app;
                            $newvm->dir = $dir;
                            $newvm->name = $request->vmname;
                            $newvm->email = $request->email;
                            $newvm->active = 1;
                            if($newvm->save()){

                                $updateip = IPs::find($newvm->ip_id);
                                $updateip->active = 0;
                                $updateip->save(); 

                                
                                Log::info($request->vmname.'- VM created');

                                echo "</br><br>";
                                echo "======================================================= <br>";
                                echo "====".$request->vmname."- VM created successfully =====";
                                echo "=======================================================<br>";
                            }

                        }

                    
                
                }else{
                        //throw new ProcessFailedException($process);
                        
                    }

                


            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        $showVmLogs = VM::find($request->id);
        $path = storage_path('app/'.$showVmLogs->dir.'/output.log');
        return File::get($path);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteVM = VM::find($id);
        //dd($deleteVM->toArray());
        // $deleteVM->active = 0;
        //     if($deleteVM->save()){
        //         return $deleteVM->id;
        //     }

        $path = storage_path('app/'.$deleteVM->dir);
        $process = new Process('terraform12 destroy -auto-approve');
        //$process = new Process('ping -c 50 www.google.com');
        $process->setTimeout(3600);
        $process->setWorkingDirectory($path);
        $process->run();
        Log::debug($process->getOutput()); 
        if ($process->isSuccessful()) {
            $deleteVM->active = 0;
            if($deleteVM->save()){
                $releaseIP = IPs::find($deleteVM->ip_id);
                $releaseIP->active = 1;
                $releaseIP->save();
            
                Log::info($deleteVM->vmname.'- VM deleted');
                return $deleteVM->id;
            }
        }


        
    }
}
