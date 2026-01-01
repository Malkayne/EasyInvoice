<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $subject;
    public $message;
    public $pdfPath;

    public function __construct($invoice, $subject, $message, $pdfPath = null)
    {
        $this->invoice = $invoice;
        $this->subject = $subject;
        $this->message = $message;
        $this->pdfPath = $pdfPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
            with: [
                'invoice' => $this->invoice,
                'customMessage' => $this->message,
                'businessName' => $this->invoice->user->businessProfile->name,
            ]
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->pdfPath && file_exists($this->pdfPath)) {
            $attachments[] = Attachment::fromPath($this->pdfPath)
                ->as('invoice-' . $this->invoice->invoice_number . '.pdf')
                ->withMime('application/pdf');
        }
        
        return $attachments;
    }
}
