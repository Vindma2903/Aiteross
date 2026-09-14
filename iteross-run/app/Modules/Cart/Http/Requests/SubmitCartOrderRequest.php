<?php

namespace App\Modules\Cart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitCartOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // The cart page posts the items list as a single JSON-encoded hidden
        // field (built client-side from localStorage), not as bracket-notation
        // array fields, so it arrives here as a string and needs decoding
        // before the "array" rule below can validate it.
        if (is_string($this->input('items'))) {
            $decoded = json_decode((string) $this->input('items'), true);

            $this->merge(['items' => is_array($decoded) ? $decoded : []]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', 'integer'],
            'items.*.sku' => ['required', 'string', 'max:255'],
            'items.*.name' => ['nullable', 'string', 'max:255'],
            'items.*.material' => ['nullable', 'string', 'max:255'],
            'items.*.price' => ['nullable', 'numeric', 'min:0'],
            'items.*.qty' => ['required', 'integer', 'min:1', 'max:100000'],
            'items.*.url' => ['nullable', 'string', 'max:2048'],
        ];
    }
}
