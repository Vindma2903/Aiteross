<?php

namespace App\Modules\Admin\Domain;

interface MailServerSettingsRepository
{
    public function get(): array;

    public function save(array $settings): void;
}
