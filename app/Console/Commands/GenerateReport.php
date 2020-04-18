<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\VM;

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
        $newvm = VM::first();
        Mail::to('mdarif.iqbal@vodafone.com')->send(new WeeklyReport($newvm));
    }
}
