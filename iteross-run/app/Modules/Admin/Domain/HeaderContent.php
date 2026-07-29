<?php

namespace App\Modules\Admin\Domain;

final class HeaderContent
{
    public static function defaults(): array
    {
        return [
            'phone'  => '+7 (495) 123-45-67',
            'email'  => 'info@iteross.ru',
            'header_nav' => [
                ['label' => 'Каталог', 'href' => '/catalog'],
                ['label' => 'О компании', 'href' => '/#about'],
                ['label' => 'Контакты', 'href' => '/#footer'],
            ],
            'socials' => [
                ['type' => 'telegram', 'href' => '#', 'icon' => '', 'enabled' => true],
                ['type' => 'max',      'href' => '#', 'icon' => '', 'enabled' => true],
                ['type' => 'vichat',   'href' => '#', 'icon' => '', 'enabled' => true],
            ],
        ];
    }
}
