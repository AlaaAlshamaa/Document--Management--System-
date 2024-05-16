<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subject;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct(string $user, string $subject, string $content)
    {
        $this->user     = $user;
        $this->subject  = $subject;
        $this->content  = $content;
    }

