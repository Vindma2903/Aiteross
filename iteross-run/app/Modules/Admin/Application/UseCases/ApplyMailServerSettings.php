<?php

namespace App\Modules\Admin\Application\UseCases;

final class ApplyMailServerSettings
{
    public function handle(array $settings): void
    {
        if (blank($settings['host'] ?? null)) {
            return;
        }

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.scheme' => ($settings['encryption'] ?? null) === 'ssl' ? 'smtps' : 'smtp',
            'mail.mailers.smtp.host' => $settings['host'],
            'mail.mailers.smtp.port' => $settings['port'],
            'mail.mailers.smtp.username' => $settings['username'] ?: null,
            'mail.mailers.smtp.password' => $settings['password'] ?: null,
            'mail.from.address' => $settings['from_address'],
            'mail.from.name' => $settings['from_name'],
        ]);
    }
}
