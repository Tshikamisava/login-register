<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($formData)
    {
        $this->content = $formData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(

            subject: $this->content['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'contact.email',
            with: [ 'firstName' => $this->content['first_name'],
             'lastName' => $this->content['last_name'],
              'contactSubject' => $this->content['subject'],
               'contactMessage' => $this->content['message'], ],
        
            text: 'contact.email-text',
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
