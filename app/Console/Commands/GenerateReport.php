<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\VM;
use PDF;
use App\Mail\WeeklyReport;

class GenerateReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will generate weekly report and mail them to managers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight",$previous_week);
        $end_week = strtotime("next saturday",$start_week);
        $start_week = date("Y-m-d h:m:s",$start_week);
        $end_week = date("Y-m-d  h:m:s",$end_week);
        //$newvm = VM::whereBetween('created_at', [$start_week,$end_week])->get();
        $newvm = VM::get();
        if(count($newvm)){
            $pdf = PDF::loadView('generatePDF', ['newvm'=>$newvm]);   
            $path = storage_path('app/pdf'); 
            $filename = date('d-m-y').'.pdf';
            $pdf->save($path.'/'.$filename); 
            
            Mail::to('mdarif.iqbal@vodafone.com')
            ->send(new WeeklyReport($newvm));
        }
        
    }
}
