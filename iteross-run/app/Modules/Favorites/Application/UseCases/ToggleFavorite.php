<?php

namespace App\Modules\Favorites\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Favorites\Application\Support\FavoriteQuery;
use App\Modules\Favorites\Infrastructure\Persistence\Eloquent\FavoriteItem;
use Illuminate\Http\Request;

class ToggleFavorite
{
    public function __construct(
        private readonly FavoriteQuery $favoriteQuery,
    ) {
    }

    public function handle(Product $product, Request $request): bool
    {
        $query = $this->favoriteQuery
            ->forRequest($request)
            ->where('product_id', $product->id);

        if ($query->exists()) {
            $query->delete();

            return false;
        }

        FavoriteItem::create([
            'user_id' => $request->user()?->id,
            'session_id' => $request->user() ? null : $request->session()->getId(),
            'product_id' => $product->id,
        ]);

        return true;
    }
}
