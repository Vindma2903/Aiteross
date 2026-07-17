<?php

namespace App\Http\Controllers;

use App\Application\Favorites\FavoriteService;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(Request $request, FavoriteService $favoriteService): View
    {
        return view('favorites.index', [
            'products' => $favoriteService->favoritesForRequest($request),
        ]);
    }

    public function toggle(Product $product, Request $request, FavoriteService $favoriteService): RedirectResponse
    {
        $isFavorite = $favoriteService->toggle($product, $request);

        return back()->with('status', $isFavorite ? 'Товар добавлен в избранное.' : 'Товар удалён из избранного.');
    }
}
