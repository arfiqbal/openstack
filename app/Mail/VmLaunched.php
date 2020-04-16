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
    public $openstackRepository;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VM $vm, OpenstackRepository $openstackRepository)
    {
        $this->vm = $vm;
        $this->openstackRepository = $openstackRepository;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('VM CREATED : '.$this->vm->jira)->view('emails.vm')
        ->with([
            'flavor' => $this->openstackRepository->getFlavorDetail($this->vm->flavor)
        ]);
    }
}
