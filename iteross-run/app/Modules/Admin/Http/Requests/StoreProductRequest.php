<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
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
