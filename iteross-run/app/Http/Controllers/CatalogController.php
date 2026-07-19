<?php

namespace App\Http\Controllers;

use App\Application\Favorites\FavoriteService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request, FavoriteService $favoriteService): View
    {
        $categories = Category::query()
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->with('category')
            ->where('is_visible', true)
            ->orderBy('name')
            ->get();

        $favoriteProductIds = $favoriteService->favoriteProductIds($request);

        return view('catalog.index', [
            'categories' => $categories,
            'products' => $products,
            'favoriteProductIds' => $favoriteProductIds,
        ]);
    }
}
