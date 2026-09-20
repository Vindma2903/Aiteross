<?php

namespace App\Modules\LeadRequests\Infrastructure\Mail;

use Throwable;

/**
 * Builds a log context that explains why a lead/callback mail was not delivered.
 * Never includes the SMTP password or the customer's personal data.
 */
final class LeadRequestMailDiagnostics
{
    public static function context(string $form, Throwable $exception, bool $hasAttachment): array
    {
        $mailer = (string) config('mail.default');

        return [
            'form' => $form,
            'exception' => $exception::class,
            'message' => $exception->getMessage(),
            'file' => $exception->getFile().':'.$exception->getLine(),
            'has_attachment' => $hasAttachment,
            'mailer' => $mailer,
            'smtp_host' => config('mail.mailers.smtp.host'),
            'smtp_port' => config('mail.mailers.smtp.port'),
            'smtp_scheme' => config('mail.mailers.smtp.scheme'),
            'smtp_username' => config('mail.mailers.smtp.username'),
            'from_address' => config('mail.from.address'),
            'recipient' => config('services.lead_requests.recipient'),
            'storage_disk' => config('services.lead_requests.disk'),
        ];
    }
}
