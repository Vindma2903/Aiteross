<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product as CatalogProduct;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku')->ignore($product?->id),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'unit_mode' => ['nullable', 'string', 'in:'.CatalogProduct::UNIT_MODE_PIECES.','.CatalogProduct::UNIT_MODE_PACKS],
            'unit_multiplier' => ['nullable', 'integer', 'min:1'],
            'analog_mode' => ['nullable', 'string', 'in:'.CatalogProduct::ANALOG_MODE_AUTOMATIC.','.CatalogProduct::ANALOG_MODE_MANUAL],
            'manual_analog_ids' => ['nullable', 'array', 'max:10'],
            'manual_analog_ids.*' => [
                'integer',
                'distinct',
                'exists:products,id',
                Rule::notIn([$product?->id]),
            ],
            'category_id' => ['nullable', 'exists:categories,id'],
            'image' => ['nullable', 'file', 'image', 'max:5120'],
            'existing_image' => [
                'nullable',
                'string',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if ($value === null || $value === '') {
                        return;
                    }

                    $allowedImages = collect(Storage::disk('public')->files('product-images'))
                        ->map(fn (string $path): string => Storage::url($path));

                    if (! $allowedImages->contains($value)) {
                        $fail('Выберите изображение из библиотеки загруженных файлов.');
                    }
                },
            ],
            'is_visible' => ['required', 'boolean'],
            'filter_option_ids' => ['nullable', 'array'],
            'filter_option_ids.*' => ['integer', 'exists:catalog_filter_options,id'],
        ];
    }
}
