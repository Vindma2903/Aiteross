<?php

namespace App\Modules\Admin\Domain;

interface HeaderContentRepository
{
    public function get(): array;

    public function save(array $content): void;
}
