<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserContactReply extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $replyMessage;

    public function __construct($contact, $replyMessage)
    {
        $this->contact = $contact;
        $this->replyMessage = $replyMessage;
    }

    public function build()
    {
        return $this->view('email.user_contact_reply')
                    ->with([
                        'name' => $this->contact->name ?? 'User',
                        'replyMessage' => $this->replyMessage,
                    ]);
    }
}
