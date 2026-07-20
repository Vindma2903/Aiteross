<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Catalog\Application\UseCases\GetCatalogFilterGroups;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AdminDashboardController
{
    use Concerns\InteractsWithStaticAdminPages;

    public function index(Request $request, GetCatalogFilterGroups $getCatalogFilterGroups): View
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

        $products = $selectedSection === 'products'
            ? Product::query()
                ->with(['category', 'filterOptions.group'])
                ->when(
                    $productSearch !== '',
                    fn ($query) => $query->where(function ($nestedQuery) use ($productSearch) {
                        $nestedQuery
                            ->where('name', 'like', '%'.$productSearch.'%')
                            ->orWhere('sku', 'like', '%'.$productSearch.'%');
                    }),
                )
                ->when(
                    $productCategory !== '',
                    fn ($query) => $query->where('category_id', (int) $productCategory),
                )
                ->orderByDesc('id')
                ->get()
            : new Collection();

        return view('admin.dashboard', [
            'user' => $request->user(),
            'staticPages' => $this->staticPages(),
            'selectedSection' => $selectedSection,
            'categories' => $categories,
            'products' => $products,
            'productSearch' => $productSearch,
            'productCategory' => $productCategory,
            'filterGroups' => $getCatalogFilterGroups->handle(false),
        ]);
    }
}
