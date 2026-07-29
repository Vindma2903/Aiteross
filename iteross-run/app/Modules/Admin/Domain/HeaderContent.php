<?php

namespace App\Modules\Admin\Domain;

final class HeaderContent
{
    public static function defaults(): array
    {
        return [
            'phone'  => '+7 (495) 123-45-67',
            'email'  => 'info@iteross.ru',
            'socials' => [
                ['type' => 'telegram', 'href' => '#', 'enabled' => true],
                ['type' => 'max',      'href' => '#', 'enabled' => true],
                ['type' => 'vichat',   'href' => '#', 'enabled' => true],
            ],
        ];
    }
}
