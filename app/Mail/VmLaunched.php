<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\VM;
use App\Repository\OpenstackRepository;

class VmLaunched extends Mailable
{
    use Queueable, SerializesModels;

    public $vm;
    public $flavor;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VM $vm, $flavor)
    {
        $this->vm = $vm;
        $this->flavor = $flavor;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('VM CREATED : '.$this->vm->jira)
                    ->view('emails.vm')
                    ->attach(public_path('doc/Access-Procedure-on-Instance-for-Cloud-Infra-V2.pdf'))
                    ->attach(public_path('Process-to-request-for-jump-server-access.docx'));
    }
}
