<?php

namespace App\Modules\Favorites\Application\UseCases;

use App\Modules\Favorites\Infrastructure\Persistence\Eloquent\FavoriteItem;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;

class MergeGuestFavoritesIntoUser
{
    public function handle(string $guestSessionId, User $user): void
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
}
