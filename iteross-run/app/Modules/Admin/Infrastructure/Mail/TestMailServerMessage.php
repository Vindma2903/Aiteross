<?php

namespace App\Modules\Admin\Infrastructure\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class TestMailServerMessage extends Mailable
{
    use Queueable;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Тестовое письмо | АЙТЕРОСС',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.test-mail-server-message',
        );
    }
}
