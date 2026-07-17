<?php

namespace App\Application\Favorites;

use App\Models\FavoriteItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FavoriteService
{
    public function favoritesForRequest(Request $request): Collection
    {
        return $this->favoriteQuery($request)
            ->with('product')
            ->latest()
            ->get()
            ->pluck('product')
            ->filter();
    }

    public function favoriteProductIds(Request $request): array
    {
        return $this->favoriteQuery($request)
            ->pluck('product_id')
            ->all();
    }

    public function isFavorite(Product $product, Request $request): bool
    {
        return $this->favoriteQuery($request)
            ->where('product_id', $product->id)
            ->exists();
    }

    public function toggle(Product $product, Request $request): bool
    {
        $query = $this->favoriteQuery($request)->where('product_id', $product->id);

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

    public function mergeGuestFavoritesIntoUser(string $guestSessionId, User $user): void
    {
        if ($guestSessionId === '') {
            return;
        }

        $guestProductIds = FavoriteItem::query()
            ->where('session_id', $guestSessionId)
            ->pluck('product_id');

        if ($guestProductIds->isEmpty()) {
            return;
        }

        $userProductIds = FavoriteItem::query()
            ->where('user_id', $user->id)
            ->pluck('product_id');

        $missingProductIds = $guestProductIds->diff($userProductIds);

        foreach ($missingProductIds as $productId) {
            FavoriteItem::create([
                'user_id' => $user->id,
                'session_id' => null,
                'product_id' => $productId,
            ]);
        }

        FavoriteItem::query()
            ->where('session_id', $guestSessionId)
            ->delete();
    }

    protected function favoriteQuery(Request $request)
    {
        $query = FavoriteItem::query();

        if ($request->user()) {
            return $query->where('user_id', $request->user()->id);
        }

        return $query->where('session_id', $request->session()->getId());
    }
}
