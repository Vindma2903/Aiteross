<?php

namespace Tests\Feature\Admin;

use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Support\Facades\Hash;

trait HomeEditorFixtures
{
    protected function admin(): User
    {
        return User::query()->create([
            'name' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+7 (999) 000-00-00',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * A valid payload of the home page editor form.
     *
     * @param  array<string, string>  $contacts
     */
    protected function homePayload(array $contacts): array
    {
        return [
            'header_nav' => [['label' => 'О компании', 'href' => '/#about']],
            'hero' => [
                'title' => 'Заголовок',
                'description' => 'Описание',
                'cta_text' => 'Оставить заявку',
                'background_image' => '',
            ],
            'hero_benefits' => [['icon' => 'layers', 'text' => 'Преимущество']],
            'advantages' => [
                'title' => 'Преимущества',
                'description' => 'Описание преимуществ',
                'items' => [['icon' => 'doc', 'title' => 'Карточка', 'text' => 'Текст']],
            ],
            'work_types' => [
                'title' => 'Виды работ',
                'description' => 'Описание видов работ',
                'items' => [[
                    'slug' => 'tokarnye-plastiny',
                    'icon' => 'turn',
                    'image' => '',
                    'description' => 'Описание',
                ]],
            ],
            'about' => [
                'title' => 'О компании',
                'description' => 'Коротко',
                'text' => 'Текст',
                'image' => '',
            ],
            'faq' => [
                'title' => 'Вопросы',
                'description' => 'Описание',
                'items' => [['question' => 'Вопрос?', 'answer' => 'Ответ.']],
            ],
            'contacts' => $contacts,
        ];
    }
}
