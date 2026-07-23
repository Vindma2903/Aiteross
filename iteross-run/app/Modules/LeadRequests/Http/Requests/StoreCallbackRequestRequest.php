<?php

namespace App\Modules\LeadRequests\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCallbackRequestRequest extends FormRequest
{
    protected $errorBag = 'callbackRequest';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:20480'],
        ];
    }
}
