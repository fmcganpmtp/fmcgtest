<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BasicMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){

        return $this->view('mail/basic')
                    ->subject($this->subject)
                    ->with(['content' => $this->content]);

    }
}
