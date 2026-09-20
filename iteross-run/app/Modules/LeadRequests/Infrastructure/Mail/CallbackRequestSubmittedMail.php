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

    /**
     * @param  list<array{disk: string, path: string, original_name: string}>  $storedAttachments
     */
    public function __construct(
        public CallbackRequestData $data,
        public array $storedAttachments = [],
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
                'storedAttachments' => $this->storedAttachments,
            ],
        );
    }

    public function attachments(): array
    {
        return array_map(
            fn (array $file): Attachment => Attachment::fromStorageDisk($file['disk'], $file['path'])
                ->as($file['original_name']),
            $this->storedAttachments,
        );
    }
}
