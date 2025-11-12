<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendCompliantToSubscriberEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private string $senderName,
        private string $phoneNumber,
        private int $messageType,
        private string $message,
        private string $subscriber_business_name,
        private string $branch_ar_name
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Compliant & Suggestions',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'sendCompliantToSubscriberEmail',
            with:['senderName' => $this->senderName,
                'senderPhoneNumber' => $this->phoneNumber,
                'messageType' => $this->messageType == 1 ? 'complaint' : 'suggestion',
                'userMessage' => $this->message,
                'businessName' => $this->subscriber_business_name,
                'branchName' => $this->branch_ar_name,
                'dateTime' => now() ]
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
