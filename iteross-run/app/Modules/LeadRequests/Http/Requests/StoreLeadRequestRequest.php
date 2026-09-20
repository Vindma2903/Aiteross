<?php

namespace App\Modules\LeadRequests\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreLeadRequestRequest extends FormRequest
{
    use ValidatesAttachments;

    /**
     * Keep the visitor at the form when validation fails; the browser does not
     * send the #fragment in the Referer, so the default redirect lands on the page top.
     */
    protected function getRedirectUrl(): string
    {
        return rtrim(url('/'), '/').'/#lead-form-section';
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'task_description' => ['required', 'string', 'max:5000'],
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
