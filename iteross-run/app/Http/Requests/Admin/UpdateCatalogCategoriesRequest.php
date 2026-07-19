<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCatalogCategoriesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categories' => ['required', 'array', 'min:1'],
            'categories.*.name' => ['required', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $categories = collect($this->input('categories', []))
            ->map(function ($category) {
                return [
                    'name' => trim((string) ($category['name'] ?? '')),
                ];
            })
            ->filter(fn (array $category) => $category['name'] !== '')
            ->values()
            ->all();

        $this->merge([
            'categories' => $categories,
        ]);
    }
}
