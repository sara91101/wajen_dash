<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class CustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->details["title"],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $body = "";
        if($this->details["body"] != "")
        {
            $body = $this->details["body"];
        }

        return new Content(
            view: 'mailing',
                 with: [
                     'body' => $body,
                     ],
         );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if($this->details['path'] != "")
        {
            return [
                Attachment::fromPath(public_path($this->details['path']))
                ->as("Invoice.pdf")
                ->withMime('application/pdf'),
            ];
        }
        else
        {
            return [];
        }
    }
}
