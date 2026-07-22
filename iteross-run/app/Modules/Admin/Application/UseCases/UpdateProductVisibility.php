<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;

class UpdateProductVisibility
{
    public function handle(Product $product, bool $isVisible): bool
    {
        $product->update([
            'is_visible' => $isVisible,
        ]);

        return $isVisible;
    }
}
