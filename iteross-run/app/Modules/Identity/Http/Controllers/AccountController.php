<?php

namespace App\Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
use App\Modules\Favorites\Application\UseCases\GetFavoritesForRequest;
use App\Modules\Orders\Infrastructure\Persistence\Eloquent\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __invoke(
        Request $request,
        GetFavoritesForRequest $getFavorites,
        GetFavoriteProductIdsForRequest $getFavoriteIds,
    ): View {
        $user = $request->user();
        $orders = Order::query()
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->get();

        return view('account.index', [
            'user'          => $user,
            'section'       => $request->query('section', 'profile'),
            'favorites'     => $getFavorites->handle($request),
            'favoriteCount' => count($getFavoriteIds->handle($request)),
            'orders'        => $orders,
        ]);
    }
}
