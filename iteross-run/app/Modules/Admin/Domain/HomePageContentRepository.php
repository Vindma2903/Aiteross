<?php

namespace App\Modules\Admin\Domain;

interface HomePageContentRepository
{
    public function get(): array;

    public function save(array $content): void;
}
