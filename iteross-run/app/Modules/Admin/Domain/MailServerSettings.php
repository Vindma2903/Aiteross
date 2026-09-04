<?php

namespace App\Modules\Admin\Domain;

final class MailServerSettings
{
    public static function defaults(): array
    {
        return [
            'host' => '',
            'port' => 587,
            'encryption' => 'tls',
            'username' => '',
            'password' => '',
            'from_address' => '',
            'from_name' => config('app.name', 'АЙТЕРОСС'),
        ];
    }
}
