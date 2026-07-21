<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Application\UseCases\StoreProductImage;
use App\Modules\Admin\Application\UseCases\UpdateProductVisibility;
use App\Modules\Admin\Http\Requests\StoreProductRequest;
use App\Modules\Admin\Http\Requests\UpdateProductRequest;
use App\Modules\Admin\Http\Requests\UpdateProductVisibilityRequest;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function store(
        StoreProductRequest $request,
        StoreProductImage $storeProductImage,
    ): RedirectResponse {
        $data = $request->validated();
        $filterOptionIds = $data['filter_option_ids'] ?? [];
        unset($data['filter_option_ids']);

        if ($request->hasFile('image')) {
            $data['image'] = $storeProductImage->handle($request->file('image'));
        }

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
        unset($data['filter_option_ids']);

        if ($request->hasFile('image')) {
            $data['image'] = $storeProductImage->handle($request->file('image'), $product->image);
        } else {
            unset($data['image']);
        }

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

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар удалён.');
    }

    private function resolveVisibility(array $data): bool
    {
        if (($data['stock_quantity'] ?? 0) <= 0) {
            return false;
        }

        return (bool) ($data['is_visible'] ?? false);
    }
}
