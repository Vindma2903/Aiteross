<?php

namespace App\Modules\LeadRequests\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreCallbackRequestRequest extends FormRequest
{
    use ValidatesAttachments;

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
            ...$this->attachmentRules(),
        ];
    }

    public function messages(): array
    {
        return $this->attachmentMessages();
    }

    /**
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [fn (Validator $validator) => $this->validateTotalAttachmentSize($validator)];
    }
}
