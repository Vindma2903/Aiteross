<?php

namespace App\Http\Controllers;

use App\Application\Favorites\FavoriteService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request, FavoriteService $favoriteService): View
    {
        $products = Product::query()->orderBy('name')->get();
        $favoriteProductIds = $favoriteService->favoriteProductIds($request);

        return view('catalog.index', [
            'products' => $products,
            'favoriteProductIds' => $favoriteProductIds,
        ]);
    }
}
