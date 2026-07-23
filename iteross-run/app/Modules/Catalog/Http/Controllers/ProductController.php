<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Application\UseCases\GetProductPageSettings;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(
        string $slug,
        Request $request,
        GetFavoriteProductIdsForRequest $getFavoriteProductIdsForRequest,
        GetProductPageSettings $getProductPageSettings,
    ): View {
        $product = Product::query()
            ->with(['category', 'filterOptions.group', 'manualAnalogs.category'])
            ->where('slug', $slug)
            ->where('is_visible', true)
            ->firstOrFail();

        $productPageSettings = $getProductPageSettings->handle();
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

        $visibleFilterSpecs = $product->filterOptions
            ->groupBy('group.name')
            ->map(function (Collection $options, string $groupName) use ($productPageSettings) {
                $rowKey = $this->resolveSpecRowKey($groupName);

                if ($rowKey !== null && ! data_get($productPageSettings, 'rows.'.$rowKey, true)) {
                    return null;
                }

                if ($this->isMaterialsGroup($groupName) && ! data_get($productPageSettings, 'blocks.show_materials', true)) {
                    return null;
                }

                if ($this->isProcessingTypesGroup($groupName) && ! data_get($productPageSettings, 'blocks.show_processing_types', true)) {
                    return null;
                }

                return [
                    'name' => $groupName,
                    'value' => $options->pluck('name')->implode(', '),
                ];
            })
            ->filter()
            ->values();

        return view('catalog.show', [
            'product' => $product,
            'favoriteProductIds' => $favoriteProductIds,
            'imageUrl' => $imageUrl,
            'analogProducts' => $analogProducts,
            'productPageSettings' => $productPageSettings,
            'visibleFilterSpecs' => $visibleFilterSpecs,
        ]);
    }

    private function resolveSpecRowKey(string $groupName): ?string
    {
        $normalized = mb_strtolower($groupName);

        return match (true) {
            str_contains($normalized, 'бренд') => 'brand',
            str_contains($normalized, 'геометр') => 'geometry',
            str_contains($normalized, 'форма') => 'shape',
            str_contains($normalized, 'размер') => 'size',
            str_contains($normalized, 'радиус') => 'radius',
            str_contains($normalized, 'задн') || str_contains($normalized, 'угол') => 'back_angle',
            str_contains($normalized, 'конструк') => 'construction',
            str_contains($normalized, 'материал пластины') => 'plate_material',
            str_contains($normalized, 'сплав') => 'alloy',
            str_contains($normalized, 'стружк') => 'chipbreaker',
            default => null,
        };
    }

    private function isMaterialsGroup(string $groupName): bool
    {
        $normalized = mb_strtolower($groupName);

        return str_contains($normalized, 'iso')
            || str_contains($normalized, 'обрабатываем')
            || str_contains($normalized, 'материал');
    }

    private function isProcessingTypesGroup(string $groupName): bool
    {
        $normalized = mb_strtolower($groupName);

        return str_contains($normalized, 'тип обработки')
            || str_contains($normalized, 'обработка');
    }
}
