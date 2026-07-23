<?php

namespace App\Modules\LeadRequests\Application\UseCases;

use App\Modules\LeadRequests\Application\DataTransfer\LeadRequestData;
use App\Modules\LeadRequests\Infrastructure\Mail\LeadRequestSubmittedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

final class SubmitLeadRequest
{
    public function handle(LeadRequestData $data): void
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
                'mime' => $data->attachment->getClientMimeType(),
            ];
        }

        Mail::to((string) config('services.lead_requests.recipient'))
            ->send(new LeadRequestSubmittedMail($data, $storedAttachment));
    }
}
