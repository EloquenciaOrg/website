<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemberRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $token;
    public $confirmationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($firstname, $token)
    {
        $this->firstname = $firstname;
        $this->token = $token;
        $this->confirmationUrl = config('helloasso.web_url') . "/registrationconfirmation?token={$token}";
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Finalisation de votre inscription chez Eloquéncia',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            text: 'emails.member-registration',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
