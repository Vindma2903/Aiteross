<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateHomePageContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле «:attribute» нужно заполнить.',
            'max' => 'Значение поля «:attribute» слишком большое (максимум: :max).',
            'min' => 'Поле «:attribute» заполнено неверно (минимум: :min).',
            'email' => 'Поле «:attribute» должно содержать корректный email.',
            'contacts.email.email' => 'Введите корректный email, например info@iteross.ru.',
            'contacts.*.max' => 'Слишком длинное значение, сократите текст.',
        ];
    }

    public function attributes(): array
    {
        return [
            'header_nav.*.label' => 'Меню: название пункта',
            'header_nav.*.href' => 'Меню: ссылка',
            'hero.title' => 'Первый экран: заголовок',
            'hero.description' => 'Первый экран: описание',
            'hero.cta_text' => 'Первый экран: текст кнопки',
            'hero_benefits.*.text' => 'Первый экран: преимущество',
            'advantages.title' => 'Преимущества: заголовок',
            'advantages.description' => 'Преимущества: описание',
            'advantages.items.*.title' => 'Преимущества: заголовок карточки',
            'advantages.items.*.text' => 'Преимущества: текст карточки',
            'work_types.title' => 'Виды работ: заголовок',
            'work_types.description' => 'Виды работ: описание блока',
            'work_types.items.*.description' => 'Виды работ: описание категории',
            'about.title' => 'О компании: заголовок',
            'about.description' => 'О компании: подзаголовок',
            'about.text' => 'О компании: основной текст',
            'faq.title' => 'Вопросы: заголовок',
            'faq.description' => 'Вопросы: описание',
            'faq.items.*.question' => 'Вопросы: вопрос',
            'faq.items.*.answer' => 'Вопросы: ответ',
            'contacts.phone' => 'Контакты: телефон',
            'contacts.email' => 'Контакты: email',
            'contacts.address' => 'Контакты: адрес',
        ];
    }

    /**
     * A rejected form used to fail silently: the page reloaded with the typed values and
     * nothing was saved. Record what was rejected so it can be found in the log.
     */
    protected function failedValidation(Validator $validator): void
    {
        Log::warning('Admin page update was rejected by validation, nothing was saved.', [
            'page' => $this->route('page'),
            'errors' => $validator->errors()->toArray(),
        ]);

        parent::failedValidation($validator);
    }

    public function rules(): array
    {
        if ($this->route('page') === 'header') {
            return [
                'phone'              => ['required', 'string', 'max:30'],
                'email'              => ['required', 'email', 'max:200'],
                'header_nav'         => ['nullable', 'array'],
                'header_nav.*.label' => ['required', 'string', 'max:120'],
                'header_nav.*.href'  => ['required', 'string', 'max:255'],
                'socials'            => ['required', 'array', 'size:3'],
                'socials.*.type'     => ['required', 'string', 'in:telegram,max,vichat'],
                'socials.*.href'     => ['required', 'string', 'max:500'],
                'socials.*.icon'     => ['nullable', 'string', 'max:1000'],
                'socials.*.enabled'  => ['required', 'boolean'],
            ];
        }

        if ($this->route('page') === 'delivery') {
            return [
                'hero.title' => ['required', 'string', 'max:255'],
                'hero.lead' => ['required', 'string'],

                'cards' => ['required', 'array', 'size:2'],
                'cards.*.title' => ['required', 'string', 'max:255'],
                'cards.*.text' => ['required', 'string'],

                'terms.title' => ['required', 'string', 'max:255'],
                'terms.items' => ['required', 'array', 'min:1'],
                'terms.items.*.text' => ['required', 'string'],
                'terms.panel.label' => ['required', 'string', 'max:255'],
                'terms.panel.address' => ['required', 'string', 'max:255'],
                'terms.panel.phone' => ['required', 'string', 'max:120'],
                'terms.panel.schedule' => ['required', 'string', 'max:120'],

                'cta.title' => ['required', 'string', 'max:255'],
                'cta.text' => ['required', 'string'],
                'cta.button_text' => ['required', 'string', 'max:120'],
            ];
        }

        if ($this->route('page') === 'product') {
            return [
                'photo_count' => ['required', 'integer', 'min:1', 'max:10'],
                'blocks.show_stock' => ['required', 'boolean'],
                'blocks.show_analogs' => ['required', 'boolean'],
                'blocks.show_also_bought' => ['required', 'boolean'],
                'blocks.show_cart' => ['required', 'boolean'],
                'blocks.show_wish' => ['required', 'boolean'],
                'blocks.show_materials' => ['required', 'boolean'],
                'blocks.show_processing_types' => ['required', 'boolean'],
                'rows.brand' => ['required', 'boolean'],
                'rows.geometry' => ['required', 'boolean'],
                'rows.shape' => ['required', 'boolean'],
                'rows.size' => ['required', 'boolean'],
                'rows.radius' => ['required', 'boolean'],
                'rows.back_angle' => ['required', 'boolean'],
                'rows.construction' => ['required', 'boolean'],
                'rows.plate_material' => ['required', 'boolean'],
                'rows.alloy' => ['required', 'boolean'],
                'rows.chipbreaker' => ['required', 'boolean'],
            ];
        }

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
            'work_types.items.*.description' => ['nullable', 'string'],

            'about.title' => ['required', 'string', 'max:255'],
            'about.description' => ['required', 'string'],
            'about.text' => ['required', 'string'],
            'about.image' => ['nullable', 'string', 'max:1000'],

            'faq.title' => ['required', 'string', 'max:255'],
            'faq.description' => ['required', 'string'],
            'faq.items' => ['required', 'array', 'min:1'],
            'faq.items.*.question' => ['required', 'string', 'max:255'],
            'faq.items.*.answer' => ['required', 'string'],

            // Contacts next to the lead form and in the site footer; an empty field hides that item.
            'contacts' => ['nullable', 'array'],
            'contacts.phone' => ['nullable', 'string', 'max:50'],
            'contacts.phone_note' => ['nullable', 'string', 'max:255'],
            'contacts.email' => ['nullable', 'email', 'max:200'],
            'contacts.email_note' => ['nullable', 'string', 'max:255'],
            'contacts.address' => ['nullable', 'string', 'max:500'],
            'contacts.requisites_name' => ['nullable', 'string', 'max:255'],
            'contacts.requisites_details' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
