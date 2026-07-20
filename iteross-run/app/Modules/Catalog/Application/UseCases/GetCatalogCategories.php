<?php

namespace App\Modules\Catalog\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use Illuminate\Support\Collection;

class GetCatalogCategories
{
    public function handle(): Collection
    {
        return Category::query()
            ->withCount([
                'products as products_count' => fn ($query) => $query->where('is_visible', true),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
}
