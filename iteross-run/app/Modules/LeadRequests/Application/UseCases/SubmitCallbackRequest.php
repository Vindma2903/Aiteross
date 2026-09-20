<?php

namespace App\Modules\LeadRequests\Application\UseCases;

use App\Modules\LeadRequests\Application\DataTransfer\CallbackRequestData;
use App\Modules\LeadRequests\Infrastructure\Mail\CallbackRequestSubmittedMail;
use App\Modules\LeadRequests\Infrastructure\Mail\LeadRequestMailDiagnostics;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

final class SubmitCallbackRequest
{
    /**
     * @return bool false when the request could not be delivered (the reason is logged).
     */
    public function handle(CallbackRequestData $data): bool
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
                ];
            }

            Mail::to((string) config('services.lead_requests.recipient'))
                ->send(new CallbackRequestSubmittedMail($data, $storedAttachment));
        } catch (Throwable $exception) {
            Log::error(
                'Callback request was not delivered.',
                LeadRequestMailDiagnostics::context('callback-request', $exception, $data->attachment !== null),
            );

            return false;
        }

        Log::info('Callback request delivered.', [
            'form' => 'callback-request',
            'recipient' => config('services.lead_requests.recipient'),
        ]);

        return true;
    }
}
