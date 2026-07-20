<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Application\UseCases\GetCatalogCategories;
use App\Modules\Catalog\Application\UseCases\GetCatalogFilterGroups;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(
        Request $request,
        GetCatalogCategories $getCatalogCategories,
        GetCatalogFilterGroups $getCatalogFilterGroups,
        GetFavoriteProductIdsForRequest $getFavoriteProductIdsForRequest,
        ?string $categorySlug = null,
    ): View
    {
        $selectedCategory = null;
        $categories = $getCatalogCategories->handle();
        $filterGroups = $getCatalogFilterGroups->handle();
        $selectedFilterOptionIds = collect($request->input('filters', []))
            ->flatMap(fn ($values) => is_array($values) ? $values : [])
            ->map(fn ($value) => (int) $value)
            ->filter()
            ->values();

        if ($categorySlug !== null && $categorySlug !== '') {
            $selectedCategory = $categories->firstWhere('slug', trim($categorySlug));
        }

        $products = Product::query()
            ->with(['category', 'filterOptions.group'])
            ->where('is_visible', true)
            ->when($selectedCategory, fn ($query) => $query->where('category_id', $selectedCategory->id))
            ->when(
                $selectedFilterOptionIds->isNotEmpty(),
                function ($query) use ($request, $filterGroups) {
                    /** @var Collection<int, mixed> $filterGroups */
                    foreach ($filterGroups as $group) {
                        $optionIds = collect($request->input("filters.{$group->id}", []))
                            ->map(fn ($value) => (int) $value)
                            ->filter()
                            ->values();

                        if ($optionIds->isEmpty()) {
                            continue;
                        }

                        $query->whereHas('filterOptions', fn ($nestedQuery) => $nestedQuery->whereIn('catalog_filter_options.id', $optionIds));
                    }
                }
            )
            ->orderBy('name')
            ->get();

        $favoriteProductIds = $getFavoriteProductIdsForRequest->handle($request);

        return view('catalog.index', [
            'categories' => $categories,
            'products' => $products,
            'favoriteProductIds' => $favoriteProductIds,
            'selectedCategory' => $selectedCategory,
            'filterGroups' => $filterGroups,
            'selectedFilterOptionIds' => $selectedFilterOptionIds,
        ]);
    }
}
