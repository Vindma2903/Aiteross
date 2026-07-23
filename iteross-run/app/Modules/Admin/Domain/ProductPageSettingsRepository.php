<?php

namespace App\Modules\Admin\Domain;

interface ProductPageSettingsRepository
{
    public function get(): array;

    public function save(array $settings): void;
}
