<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $link) {}

    public function build()
    {
        return $this->view('emails.payment-link')
                    ->with(['link' => $this->link])
                    ->subject('Payment Link Mail');
    }
}
