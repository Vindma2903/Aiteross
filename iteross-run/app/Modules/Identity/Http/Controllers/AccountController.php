<?php

namespace App\Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
use App\Modules\Favorites\Application\UseCases\GetFavoritesForRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __invoke(
        Request $request,
        GetFavoritesForRequest $getFavorites,
        GetFavoriteProductIdsForRequest $getFavoriteIds,
    ): View {
        return view('account.index', [
            'user'          => $request->user(),
            'section'       => $request->query('section', 'profile'),
            'favorites'     => $getFavorites->handle($request),
            'favoriteCount' => count($getFavoriteIds->handle($request)),
        ]);
    }
}
