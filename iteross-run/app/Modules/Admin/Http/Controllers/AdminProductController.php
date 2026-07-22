<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Application\UseCases\ImportProductsFromSpreadsheet;
use App\Modules\Admin\Application\UseCases\StoreProductImage;
use App\Modules\Admin\Application\UseCases\UpdateProductVisibility;
use App\Modules\Admin\Http\Requests\ImportProductsRequest;
use App\Modules\Admin\Http\Requests\StoreProductRequest;
use App\Modules\Admin\Http\Requests\UpdateProductRequest;
use App\Modules\Admin\Http\Requests\UpdateProductVisibilityRequest;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use RuntimeException;

class AdminProductController extends Controller
{
    public function store(
        StoreProductRequest $request,
        StoreProductImage $storeProductImage,
    ): RedirectResponse {
        $data = $request->validated();
        $filterOptionIds = $data['filter_option_ids'] ?? [];
        $existingImage = $data['existing_image'] ?? null;
        unset($data['filter_option_ids'], $data['existing_image']);

        if ($request->hasFile('image')) {
            $data['image'] = $storeProductImage->handle($request->file('image'));
        } elseif ($existingImage) {
            $data['image'] = $existingImage;
        }

        $data = $this->normalizeUnitData($data);
        $data['is_visible'] = $this->resolveVisibility($data);
        $data['slug'] = Str::slug($data['name'].'-'.$data['sku']);

        $product = Product::query()->create($data);
        $product->filterOptions()->sync($filterOptionIds);

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар создан.');
    }

    public function update(
        UpdateProductRequest $request,
        Product $product,
        StoreProductImage $storeProductImage,
    ): RedirectResponse {
        $data = $request->validated();
        $filterOptionIds = $data['filter_option_ids'] ?? [];
        $existingImage = $data['existing_image'] ?? null;
        unset($data['filter_option_ids'], $data['existing_image']);

        if ($request->hasFile('image')) {
            $data['image'] = $storeProductImage->handle($request->file('image'), $product->image);
        } elseif ($existingImage) {
            $data['image'] = $existingImage;
        } else {
            unset($data['image']);
        }

        $data = $this->normalizeUnitData($data);
        $data['is_visible'] = $this->resolveVisibility($data);
        $data['slug'] = Str::slug($data['name'].'-'.$data['sku']);

        $product->update($data);
        $product->filterOptions()->sync($filterOptionIds);

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар обновлён.');
    }

    public function updateVisibility(
        UpdateProductVisibilityRequest $request,
        Product $product,
        UpdateProductVisibility $updateProductVisibility,
    ): RedirectResponse {
        $isVisible = $request->boolean('is_visible');
        $actualVisibility = $updateProductVisibility->handle($product, $isVisible);

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', $actualVisibility ? 'Товар показывается в каталоге.' : 'Товар скрыт из каталога.');
    }

    public function import(
        ImportProductsRequest $request,
        ImportProductsFromSpreadsheet $importProductsFromSpreadsheet,
    ): RedirectResponse {
        try {
            $result = $importProductsFromSpreadsheet->handle($request->file('file'));
        } catch (RuntimeException $exception) {
            return redirect()
                ->route('admin.dashboard', ['section' => 'products'])
                ->withErrors(['file' => $exception->getMessage()], 'importProducts')
                ->withInput([
                    '_open_import_modal' => '1',
                ]);
        }

        $parts = [];
        if ($result['created'] > 0) {
            $parts[] = 'создано: '.$result['created'];
        }
        if ($result['updated'] > 0) {
            $parts[] = 'обновлено: '.$result['updated'];
        }
        if ($result['skipped'] > 0) {
            $parts[] = 'пропущено: '.$result['skipped'];
        }

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Импорт товаров завершён'.($parts !== [] ? ' ('.implode(', ', $parts).').' : '.'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар удалён.');
    }

    private function resolveVisibility(array $data): bool
    {
        return (bool) ($data['is_visible'] ?? false);
    }

    private function normalizeUnitData(array $data): array
    {
        $data['unit_mode'] = ($data['unit_mode'] ?? Product::UNIT_MODE_PIECES) === Product::UNIT_MODE_PACKS
            ? Product::UNIT_MODE_PACKS
            : Product::UNIT_MODE_PIECES;

        $data['unit_multiplier'] = max(1, (int) ($data['unit_multiplier'] ?? 1));

        if ($data['unit_mode'] === Product::UNIT_MODE_PIECES) {
            $data['unit_multiplier'] = 1;
        }

        return $data;
    }
}
