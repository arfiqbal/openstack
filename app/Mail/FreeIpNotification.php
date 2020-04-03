<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\VM;

class IpUpdateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $vm;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VM $vm)
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
        return $this->view('emails.ipNotification');
    }
}
