<?php

namespace App\Modules\Admin\Domain;

interface DeliveryPageContentRepository
{
    public function get(): array;

    public function save(array $content): void;
}
