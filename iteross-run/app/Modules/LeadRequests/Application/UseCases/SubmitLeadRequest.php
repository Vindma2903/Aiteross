<?php

namespace App\Modules\LeadRequests\Application\UseCases;

use App\Modules\LeadRequests\Application\DataTransfer\LeadRequestData;
use App\Modules\LeadRequests\Infrastructure\Mail\LeadRequestMailDiagnostics;
use App\Modules\LeadRequests\Infrastructure\Mail\LeadRequestSubmittedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class SubmitLeadRequest
{
    public function __construct(private readonly StoreAttachments $storeAttachments) {}

    /**
     * @return bool false when the request could not be delivered (the reason is logged).
     */
    public function handle(LeadRequestData $data): bool
    {
        try {
            $storedAttachments = $this->storeAttachments->handle($data->attachments);

            Mail::to((string) config('services.lead_requests.recipient'))
                ->send(new LeadRequestSubmittedMail($data, $storedAttachments));
        } catch (Throwable $exception) {
            Log::error(
                'Lead request was not delivered.',
                LeadRequestMailDiagnostics::context('lead-request', $exception, count($data->attachments)),
            );

            return false;
        }

        Log::info('Lead request delivered.', [
            'form' => 'lead-request',
            'recipient' => config('services.lead_requests.recipient'),
            'attachments' => count($storedAttachments),
        ]);

        return true;
    }
}
