<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StorageMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private string $email,
        private string $business_name,
        private string $materialName,
        private string $currentQuantity,
        private string $reorderLevel,
        private ?string $depletionDate,
        private ?float $depletionPercentage,
        private string $unit
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تنبيه بقرب انتهاء المادة الخام',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'storageMail',
            with:['customerEmail' => $this->email,
                'customerName' => $this->business_name,
                'materialName' => $this->materialName,
                'currentQuantity' => $this->currentQuantity,
                'unit' => $this->unit,
                'depletionDate' =>  $this->depletionDate ?? null,
                'depletionPercentage' =>  $this->depletionPercentage ?? null,
                'reorderLevel' => $this->reorderLevel,
                'inventoryUrl' => 'https://yourcompany.com/orders/new',
                'companyName' => 'Skilltax',
                'companyPhone' => '0599816013',
                'companyEmail' => 'support@skilltax.sa',
                'websiteUrl' => 'https://skilltax.sa',
                'productsUrl' => 'https://skilltax.sa/packages',
                'contactUrl' => 'https://api.whatsapp.com/send/?phone=966599816013&text&type=phone_number&app_absent=0']
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
