<?php

namespace App\Modules\LeadRequests\Application\UseCases;

use App\Modules\LeadRequests\Application\DataTransfer\CallbackRequestData;
use App\Modules\LeadRequests\Infrastructure\Mail\CallbackRequestSubmittedMail;
use App\Modules\LeadRequests\Infrastructure\Mail\LeadRequestMailDiagnostics;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class SubmitCallbackRequest
{
    public function __construct(private readonly StoreAttachments $storeAttachments) {}

    /**
     * @return bool false when the request could not be delivered (the reason is logged).
     */
    public function handle(CallbackRequestData $data): bool
    {
        try {
            $storedAttachments = $this->storeAttachments->handle($data->attachments);

            Mail::to((string) config('services.lead_requests.recipient'))
                ->send(new CallbackRequestSubmittedMail($data, $storedAttachments));
        } catch (Throwable $exception) {
            Log::error(
                'Callback request was not delivered.',
                LeadRequestMailDiagnostics::context('callback-request', $exception, count($data->attachments)),
            );

            return false;
        }

        Log::info('Callback request delivered.', [
            'form' => 'callback-request',
            'recipient' => config('services.lead_requests.recipient'),
            'attachments' => count($storedAttachments),
        ]);

        return true;
    }
}
