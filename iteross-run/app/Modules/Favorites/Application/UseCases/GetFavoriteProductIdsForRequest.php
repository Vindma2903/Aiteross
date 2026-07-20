<?php

namespace App\Modules\Favorites\Application\UseCases;

use App\Modules\Favorites\Application\Support\FavoriteQuery;
use Illuminate\Http\Request;

class GetFavoriteProductIdsForRequest
{
    public function __construct(
        private readonly FavoriteQuery $favoriteQuery,
    ) {
    }

    public function handle(Request $request): array
    {
        return $this->favoriteQuery->forRequest($request)
            ->pluck('product_id')
            ->all();
    }
}
