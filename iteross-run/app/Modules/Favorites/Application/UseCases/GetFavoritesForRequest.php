<?php

namespace App\Modules\Favorites\Application\UseCases;

use App\Modules\Favorites\Application\Support\FavoriteQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GetFavoritesForRequest
{
    public function __construct(
        private readonly FavoriteQuery $favoriteQuery,
    ) {
    }

    public function handle(Request $request): Collection
    {
        return $this->favoriteQuery->forRequest($request)
            ->with('product')
            ->latest()
            ->get()
            ->pluck('product')
            ->filter();
    }
}
