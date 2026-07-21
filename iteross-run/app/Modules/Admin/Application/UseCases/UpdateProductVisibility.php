<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;

class UpdateProductVisibility
{
    public function handle(Product $product, bool $isVisible): bool
    {
        if ($product->stock_quantity <= 0) {
            $isVisible = false;
        }

        $product->update([
            'is_visible' => $isVisible,
        ]);

        return $isVisible;
    }
}
