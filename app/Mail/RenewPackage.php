<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class RenewPackage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private string $name,
        private string $membership_no,
        private string $subscription_start_at,
        private string $subscription_end_at,
        private string $billPath)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تجديد الإشتراك',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'send-renew-email',
            with:['name'=> $this->name,
            'membership_no'=>$this->membership_no,
            'subscription_start_at'=>$this-> subscription_start_at,
            'subscription_end_at'=>$this-> subscription_end_at]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if($this->billPath != "")
        {
            return [
                Attachment::fromPath(public_path("bills/$this->billPath"))
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
