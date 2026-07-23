<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(
        string $slug,
        Request $request,
        GetFavoriteProductIdsForRequest $getFavoriteProductIdsForRequest,
    ): View {
        $product = Product::query()
            ->with(['category', 'filterOptions.group', 'manualAnalogs.category'])
            ->where('slug', $slug)
            ->where('is_visible', true)
            ->firstOrFail();

        $favoriteProductIds = $getFavoriteProductIdsForRequest->handle($request);
        $imageUrl = null;

        if ($product->image) {
            $imageUrl = Str::startsWith($product->image, ['http://', 'https://', '/storage/'])
                ? $product->image
                : asset('storage/'.$product->image);
        }

        $analogProductsQuery = $product->analog_mode === Product::ANALOG_MODE_MANUAL
            ? $product->manualAnalogs()
                ->where('products.is_visible', true)
                ->with('category')
            : Product::query()
                ->with('category')
                ->where('is_visible', true)
                ->whereKeyNot($product->id)
                ->when(
                    $product->category_id,
                    fn ($query) => $query->where('category_id', $product->category_id),
                    fn ($query) => $query->whereNotNull('id'),
                )
                ->orderBy('name');

        $analogProducts = $analogProductsQuery
            ->limit($product->analog_mode === Product::ANALOG_MODE_MANUAL ? 10 : 6)
            ->get()
            ->map(function (Product $analogProduct) {
                $analogImageUrl = null;

                if ($analogProduct->image) {
                    $analogImageUrl = Str::startsWith($analogProduct->image, ['http://', 'https://', '/storage/'])
                        ? $analogProduct->image
                        : asset('storage/'.$analogProduct->image);
                }

                return [
                    'product' => $analogProduct,
                    'imageUrl' => $analogImageUrl,
                ];
            });

        return view('catalog.show', [
            'product' => $product,
            'favoriteProductIds' => $favoriteProductIds,
            'imageUrl' => $imageUrl,
            'analogProducts' => $analogProducts,
        ]);
    }
}
