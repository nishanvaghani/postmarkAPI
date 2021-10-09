<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public $link,$token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link,$token)
    {
        $this->link = $link;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->link,$this->token);
        return $this->view('mails.email');
    }
}
