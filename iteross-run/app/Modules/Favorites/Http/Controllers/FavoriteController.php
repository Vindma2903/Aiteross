<?php

namespace App\Modules\Favorites\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
use App\Modules\Favorites\Application\UseCases\GetFavoritesForRequest;
use App\Modules\Favorites\Application\UseCases\ToggleFavorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(Request $request, GetFavoritesForRequest $getFavoritesForRequest): View
    {
        return view('favorites.index', [
            'products' => $getFavoritesForRequest->handle($request),
        ]);
    }

    public function toggle(
        Product $product,
        Request $request,
        ToggleFavorite $toggleFavorite,
        GetFavoriteProductIdsForRequest $getFavoriteProductIdsForRequest,
    ): RedirectResponse|JsonResponse {
        $isFavorite = $toggleFavorite->handle($product, $request);
        $favoritesCount = count($getFavoriteProductIdsForRequest->handle($request));

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'isFavorite' => $isFavorite,
                'favoritesCount' => $favoritesCount,
                'productId' => $product->id,
            ]);
        }

        return back()->with(
            'status',
            $isFavorite
                ? 'Товар добавлен в избранное.'
                : 'Товар удалён из избранного.',
        );
    }
}
