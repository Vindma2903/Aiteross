<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomePageContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'header_nav' => ['required', 'array', 'min:1'],
            'header_nav.*.label' => ['required', 'string', 'max:120'],
            'header_nav.*.href' => ['required', 'string', 'max:255'],

            'hero.title' => ['required', 'string', 'max:255'],
            'hero.description' => ['required', 'string'],
            'hero.cta_text' => ['required', 'string', 'max:120'],
            'hero.background_image' => ['nullable', 'string', 'max:1000'],

            'hero_benefits' => ['required', 'array', 'min:1'],
            'hero_benefits.*.icon' => ['required', 'string', 'max:60'],
            'hero_benefits.*.text' => ['required', 'string', 'max:255'],

            'advantages.title' => ['required', 'string', 'max:255'],
            'advantages.description' => ['required', 'string'],
            'advantages.items' => ['required', 'array', 'min:1'],
            'advantages.items.*.icon' => ['required', 'string', 'max:60'],
            'advantages.items.*.title' => ['required', 'string', 'max:255'],
            'advantages.items.*.text' => ['required', 'string'],

            'work_types.title' => ['required', 'string', 'max:255'],
            'work_types.description' => ['required', 'string'],
            'work_types.items' => ['required', 'array', 'min:1'],
            'work_types.items.*.slug' => ['required', 'string', 'max:255'],
            'work_types.items.*.icon' => ['required', 'string', 'max:60'],
            'work_types.items.*.image' => ['nullable', 'string', 'max:1000'],
            'work_types.items.*.description' => ['required', 'string'],

            'about.title' => ['required', 'string', 'max:255'],
            'about.description' => ['required', 'string'],
            'about.text' => ['required', 'string'],
            'about.image' => ['nullable', 'string', 'max:1000'],
            'about.stats' => ['required', 'array', 'min:1'],
            'about.stats.*.value' => ['required', 'string', 'max:80'],
            'about.stats.*.label' => ['required', 'string', 'max:255'],

            'faq.title' => ['required', 'string', 'max:255'],
            'faq.description' => ['required', 'string'],
            'faq.items' => ['required', 'array', 'min:1'],
            'faq.items.*.question' => ['required', 'string', 'max:255'],
            'faq.items.*.answer' => ['required', 'string'],
        ];
    }
}
