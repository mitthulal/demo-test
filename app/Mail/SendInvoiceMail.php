<?php
namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;


class SendInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $this->invoice])->output();

        return $this->subject('Your Invoice #' . $this->invoice->invoice_number)
            ->markdown('emails.invoices.send')
            ->attachData($pdf, 'invoice_' . $this->invoice->invoice_number . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
