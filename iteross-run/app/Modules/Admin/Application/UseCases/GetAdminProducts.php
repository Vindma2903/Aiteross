<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use Illuminate\Support\Collection;

class GetAdminProducts
{
    public function handle(string $search = '', string $category = ''): Collection
    {
        $products = Product::query()
            ->with(['category', 'filterOptions.group', 'manualAnalogs'])
            ->when(
                $category !== '' && ctype_digit($category),
                fn ($query) => $query->where('category_id', (int) $category),
            )
            ->orderByDesc('id')
            ->get();

        if ($search === '') {
            return $products;
        }

        // SQLite LIKE is case-sensitive for non-ASCII (Cyrillic), so filter in PHP
        $needle = mb_strtolower($search);

        return $products->filter(function (Product $product) use ($needle): bool {
            return mb_strpos(mb_strtolower($product->name), $needle) !== false
                || mb_strpos(mb_strtolower((string) $product->sku), $needle) !== false;
        })->values();
    }
}
