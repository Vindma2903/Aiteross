<?php

namespace App\Modules\LeadRequests\Application\UseCases;

use App\Modules\LeadRequests\Application\DataTransfer\LeadRequestData;
use App\Modules\LeadRequests\Infrastructure\Mail\LeadRequestMailDiagnostics;
use App\Modules\LeadRequests\Infrastructure\Mail\LeadRequestSubmittedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

final class SubmitLeadRequest
{
    /**
     * @return bool false when the request could not be delivered (the reason is logged).
     */
    public function handle(LeadRequestData $data): bool
    {
        try {
            $storedAttachment = null;

            if ($data->attachment !== null) {
                $storedAttachment = [
                    'disk' => (string) config('services.lead_requests.disk', 'local'),
                    'path' => $data->attachment->storeAs(
                        trim((string) config('services.lead_requests.directory', 'lead-requests'), '/'),
                        sprintf(
                            '%s-%s.%s',
                            now()->format('YmdHis'),
                            Str::uuid(),
                            $data->attachment->getClientOriginalExtension()
                        ),
                        (string) config('services.lead_requests.disk', 'local')
                    ),
                    'original_name' => $data->attachment->getClientOriginalName(),
                    'mime' => $data->attachment->getClientMimeType(),
                ];
            }

            Mail::to((string) config('services.lead_requests.recipient'))
                ->send(new LeadRequestSubmittedMail($data, $storedAttachment));
        } catch (Throwable $exception) {
            Log::error(
                'Lead request was not delivered.',
                LeadRequestMailDiagnostics::context('lead-request', $exception, $data->attachment !== null),
            );

            return false;
        }

        Log::info('Lead request delivered.', [
            'form' => 'lead-request',
            'recipient' => config('services.lead_requests.recipient'),
        ]);

        return true;
    }
}
