<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductsRequest extends FormRequest
{
    protected $errorBag = 'importProducts';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:10240',
                'mimes:xlsx,csv,txt',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Выберите Excel или CSV-файл для импорта.',
            'file.file' => 'Загрузите корректный файл.',
            'file.max' => 'Размер файла не должен превышать 10 МБ.',
            'file.mimes' => 'Поддерживаются форматы .xlsx, .csv и .txt.',
        ];
    }
}
