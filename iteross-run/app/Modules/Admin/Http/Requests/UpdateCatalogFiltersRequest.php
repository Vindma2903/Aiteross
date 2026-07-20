<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCatalogFiltersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'groups' => ['required', 'array', 'min:1'],
            'groups.*.id' => ['nullable', 'integer', 'exists:catalog_filter_groups,id'],
            'groups.*.name' => ['required', 'string', 'max:255'],
            'groups.*.sort_order' => ['required', 'integer', 'min:1'],
            'groups.*.is_enabled' => ['nullable', 'boolean'],
            'groups.*.options' => ['required', 'array', 'min:1'],
            'groups.*.options.*.id' => ['nullable', 'integer', 'exists:catalog_filter_options,id'],
            'groups.*.options.*.name' => ['required', 'string', 'max:255'],
            'groups.*.options.*.sort_order' => ['required', 'integer', 'min:1'],
        ];
    }
}
