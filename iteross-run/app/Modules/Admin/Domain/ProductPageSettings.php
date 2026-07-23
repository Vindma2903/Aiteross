<?php

namespace App\Modules\Admin\Domain;

final class ProductPageSettings
{
    public static function defaults(): array
    {
        return [
            'photo_count' => 1,
            'blocks' => [
                'show_stock' => true,
                'show_analogs' => true,
                'show_also_bought' => false,
                'show_cart' => true,
                'show_wish' => true,
                'show_materials' => true,
                'show_processing_types' => true,
            ],
            'rows' => [
                'brand' => true,
                'geometry' => true,
                'shape' => true,
                'size' => true,
                'radius' => true,
                'back_angle' => true,
                'construction' => true,
                'plate_material' => true,
                'alloy' => true,
                'chipbreaker' => true,
            ],
        ];
    }
}
