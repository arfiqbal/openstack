<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\VM;

class WeeklyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $vm;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vm)
    {
        $this->vm = $vm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $path = storage_path('app/pdf'); 
        $filename = date('d-m-y').'.pdf';

        return $this->view('emails.weeklyReport')
        ->attach($path.'/'.$filename);
    }
}
