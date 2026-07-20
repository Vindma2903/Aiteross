<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Http\Requests\StoreProductRequest;
use App\Modules\Admin\Http\Requests\UpdateProductRequest;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $filterOptionIds = $data['filter_option_ids'] ?? [];
        unset($data['filter_option_ids']);

        $data['slug'] = Str::slug($data['name'].'-'.$data['sku']);

        $product = Product::query()->create($data);
        $product->filterOptions()->sync($filterOptionIds);

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар создан.');
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $filterOptionIds = $data['filter_option_ids'] ?? [];
        unset($data['filter_option_ids']);

        $data['slug'] = Str::slug($data['name'].'-'.$data['sku']);

        $product->update($data);
        $product->filterOptions()->sync($filterOptionIds);

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар обновлён.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар удалён.');
    }
}
