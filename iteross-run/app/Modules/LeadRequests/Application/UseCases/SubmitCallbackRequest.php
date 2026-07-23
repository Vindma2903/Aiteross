<?php

namespace App\Modules\LeadRequests\Application\UseCases;

use App\Modules\LeadRequests\Application\DataTransfer\CallbackRequestData;
use App\Modules\LeadRequests\Infrastructure\Mail\CallbackRequestSubmittedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

final class SubmitCallbackRequest
{
    public function handle(CallbackRequestData $data): void
    {
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
    }
}
