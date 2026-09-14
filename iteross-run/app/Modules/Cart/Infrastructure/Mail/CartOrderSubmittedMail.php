<?php

namespace App\Modules\Cart\Infrastructure\Mail;

use App\Modules\Cart\Application\DataTransfer\CartOrderData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class CartOrderSubmittedMail extends Mailable
{
    use Queueable;

    public function __construct(
        public CartOrderData $data,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новая заявка из корзины',
            replyTo: $this->data->email ? [$this->data->email] : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.cart-order-submitted',
            with: [
                'data' => $this->data,
            ],
        );
    }
}
