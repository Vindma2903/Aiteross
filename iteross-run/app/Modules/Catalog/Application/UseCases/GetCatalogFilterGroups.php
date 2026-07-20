<?php

namespace App\Modules\Catalog\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\CatalogFilterGroup;
use Illuminate\Support\Collection;

class GetCatalogFilterGroups
{
    public function handle(bool $onlyEnabled = true): Collection
    {
        return CatalogFilterGroup::query()
            ->with('options')
            ->when($onlyEnabled, fn ($query) => $query->where('is_enabled', true))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
}
