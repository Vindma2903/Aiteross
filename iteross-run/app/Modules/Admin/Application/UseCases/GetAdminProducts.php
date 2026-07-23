<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use Illuminate\Support\Collection;

class GetAdminProducts
{
    public function handle(string $search = '', string $category = ''): Collection
    {
        return Product::query()
            ->with(['category', 'filterOptions.group', 'manualAnalogs'])
            ->when(
                $search !== '',
                fn ($query) => $query->where(function ($nestedQuery) use ($search) {
                    $nestedQuery
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('sku', 'like', '%'.$search.'%');
                }),
            )
            ->when(
                $category !== '' && ctype_digit($category),
                fn ($query) => $query->where('category_id', (int) $category),
            )
            ->orderByDesc('id')
            ->get();
    }
}
