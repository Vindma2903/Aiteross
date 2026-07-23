<?php

namespace App\Modules\LeadRequests\Infrastructure\Mail;

use App\Modules\LeadRequests\Application\DataTransfer\CallbackRequestData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class CallbackRequestSubmittedMail extends Mailable
{
    use Queueable;

    public function __construct(
        public CallbackRequestData $data,
        public ?array $storedAttachment,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новая заявка на обратный звонок',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.callback-request-submitted',
            with: [
                'data' => $this->data,
                'storedAttachment' => $this->storedAttachment,
            ],
        );
    }

    public function attachments(): array
    {
        if ($this->storedAttachment === null) {
            return [];
        }

        return [
            Attachment::fromStorageDisk(
                $this->storedAttachment['disk'],
                $this->storedAttachment['path'],
            )->as($this->storedAttachment['original_name']),
        ];
    }
}
