<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterTemplateMail extends Mailable
{
    
    // use Queueable, SerializesModels;
    public $template;
    public function __construct($template)
    {
        $this->template = $template;
    }

    public function build()
    {
        return $this->view('Front_end.layouts.register.email-template');
    }
}
