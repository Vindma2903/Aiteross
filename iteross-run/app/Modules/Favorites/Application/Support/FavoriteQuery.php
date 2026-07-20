<?php

namespace App\Modules\Favorites\Application\Support;

use App\Modules\Favorites\Infrastructure\Persistence\Eloquent\FavoriteItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FavoriteQuery
{
    public function forRequest(Request $request): Builder
    {
        $query = FavoriteItem::query();

        if ($request->user()) {
            return $query->where('user_id', $request->user()->id);
        }

        return $query->where('session_id', $request->session()->getId());
    }
}
