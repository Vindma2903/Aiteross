<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Application\UseCases\GetAdminProducts;
use App\Modules\Catalog\Application\UseCases\GetCatalogFilterGroups;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminDashboardController
{
    use Concerns\InteractsWithStaticAdminPages;

    public function index(
        Request $request,
        GetCatalogFilterGroups $getCatalogFilterGroups,
        GetAdminProducts $getAdminProducts,
    ): View
    {
        $selectedSection = $request->query('section', 'pages');
        $allowedSections = ['pages', 'orders', 'products'];

        if (! in_array($selectedSection, $allowedSections, true)) {
            $selectedSection = 'pages';
        }

        $productSearch = trim((string) $request->query('search', ''));
        $productCategory = (string) $request->query('category', '');

        $categories = Category::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $shouldLoadProducts = in_array($selectedSection, ['orders', 'products'], true);

        $products = $shouldLoadProducts
            ? $getAdminProducts->handle(
                $selectedSection === 'products' ? $productSearch : '',
                $selectedSection === 'products' ? $productCategory : '',
            )
            : new Collection();
        $productImageLibrary = $selectedSection === 'products'
            ? collect(Storage::disk('public')->files('product-images'))
                ->map(function (string $path): array {
                    return [
                        'name' => basename($path),
                        'path' => $path,
                        'url' => Storage::url($path),
                        'updated_at' => Storage::disk('public')->lastModified($path),
                    ];
                })
                ->sortByDesc('updated_at')
                ->values()
            : new Collection();

        return view('admin.dashboard', [
            'user' => $request->user(),
            'staticPages' => $this->staticPages(),
            'selectedSection' => $selectedSection,
            'categories' => $categories,
            'products' => $products,
            'productImageLibrary' => $productImageLibrary,
            'productSearch' => $productSearch,
            'productCategory' => $productCategory,
            'filterGroups' => $getCatalogFilterGroups->handle(false),
        ]);
    }
}
