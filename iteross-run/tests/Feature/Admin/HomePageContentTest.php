<?php

namespace Tests\Feature\Admin;

use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomePageContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_home_page_content(): void
    {
        Storage::fake('local');

        $admin = User::query()->create([
            'name' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+7 (999) 000-00-00',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.pages.update', ['page' => 'home']), [
                'header_nav' => [
                    ['label' => 'О компании', 'href' => '/#about'],
                ],
                'hero' => [
                    'title' => 'Новый заголовок главной',
                    'description' => 'Новое описание главной страницы',
                    'cta_text' => 'Оставить заявку',
                    'background_image' => 'https://example.com/hero.jpg',
                ],
                'hero_benefits' => [
                    ['icon' => 'layers', 'text' => 'Преимущество 1'],
                ],
                'advantages' => [
                    'title' => 'Преимущества',
                    'description' => 'Описание преимуществ',
                    'items' => [
                        ['icon' => 'doc', 'title' => 'Карточка', 'text' => 'Текст карточки'],
                    ],
                ],
                'work_types' => [
                    'title' => 'Виды работ',
                    'description' => 'Описание видов работ',
                    'items' => [
                        [
                            'slug' => 'tokarnye-plastiny',
                            'icon' => 'turn',
                            'image' => 'https://example.com/work.jpg',
                            'description' => 'Описание токарных пластин',
                        ],
                    ],
                ],
                'about' => [
                    'title' => 'О компании',
                    'description' => 'Коротко о компании',
                    'text' => 'Основной текст о компании',
                    'image' => 'https://example.com/about.jpg',
                    'stats' => [
                        ['value' => '300+', 'label' => 'позиций'],
                    ],
                ],
                'faq' => [
                    'title' => 'Частые вопросы',
                    'description' => 'Описание FAQ',
                    'items' => [
                        ['question' => 'Вопрос?', 'answer' => 'Ответ.'],
                    ],
                ],
            ]);

        $response->assertRedirect(route('admin.pages.editor', ['page' => 'home']));
        $response->assertSessionHas('status', 'Изменения главной страницы сохранены.');

        Storage::disk('local')->assertExists('page-content/home.json');

        $stored = json_decode(Storage::disk('local')->get('page-content/home.json'), true);

        $this->assertSame('Новый заголовок главной', $stored['hero']['title']);
        $this->assertSame('Описание токарных пластин', $stored['work_types']['items']['tokarnye-plastiny']['description']);

        $homeResponse = $this->get('/');

        $homeResponse->assertOk();
        $homeResponse->assertSee('Новый заголовок главной');
        $homeResponse->assertSee('Описание FAQ');
    }

    public function test_regular_user_cannot_update_home_page_content(): void
    {
        $user = User::query()->create([
            'name' => 'User',
            'first_name' => 'Regular',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+7 (999) 111-11-11',
            'role' => User::ROLE_USER,
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.pages.update', ['page' => 'home']), []);

        $response->assertRedirect(route('account'));
    }
}
