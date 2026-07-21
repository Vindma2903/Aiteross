<?php

namespace App\Modules\Admin\Http\Controllers\Concerns;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use Illuminate\Support\Facades\File;

trait InteractsWithStaticAdminPages
{
    private const STATIC_PAGES = [
        'home' => ['label' => 'Главная', 'file' => 'Главная АЙТЕРОСС.dc.html'],
        'catalog' => ['label' => 'Категории', 'file' => 'Каталог.dc.html'],
        'delivery' => ['label' => 'Доставка', 'file' => 'Доставка.dc.html'],
        'product' => ['label' => 'Карточка товара', 'file' => 'Товар.dc.html'],
        'account' => ['label' => 'Личный кабинет', 'file' => 'Личный кабинет.dc.html'],
        'auth' => ['label' => 'Авторизация', 'file' => 'Авторизация.dc.html'],
        'register' => ['label' => 'Регистрация', 'file' => 'Регистрация.dc.html'],
        'admin-login' => ['label' => 'Вход администратора', 'file' => 'Вход администратора.dc.html'],
        'admin-legacy' => ['label' => 'Старая админка', 'file' => 'Админка.dc.html'],
    ];

    protected function staticPages(): array
    {
        return self::STATIC_PAGES;
    }

    protected function rewriteStaticHtml(string $html): string
    {
        $html = str_replace('./support.js', route('admin.static.resource', ['path' => 'support.js']), $html);
        $html = str_replace('./image-slot.js', route('admin.static.resource', ['path' => 'image-slot.js']), $html);
        $html = str_replace('./assets/', route('admin.static.resource', ['path' => 'assets']).'/', $html);
        $html = str_replace('./uploads/', route('admin.static.resource', ['path' => 'uploads']).'/', $html);

        foreach ($this->staticPages() as $slug => $meta) {
            $previewUrl = route('admin.static.preview', ['page' => $slug]);
            $html = str_replace('./'.$meta['file'], $previewUrl, $html);
            $html = str_replace($meta['file'], $previewUrl, $html);
        }

        return $html;
    }

    protected function legacyAdminHtml(): string
    {
        $filePath = $this->workspaceRoot().DIRECTORY_SEPARATOR.'Админка.dc.html';
        abort_unless(File::exists($filePath), 404);

        return $this->rewriteStaticHtml(File::get($filePath));
    }

    protected function patchLegacyAdminPageEditor(string $html, string $page): string
    {
        $html = preg_replace("/tab:\s*'[^']+'/", "tab: 'page'", $html, 1) ?? $html;
        $html = preg_replace("/selectedPageId:\s*'[^']+'/", "selectedPageId: '".$page."'", $html, 1) ?? $html;

        return $this->stripLegacySidebar($html);
    }

    protected function patchLegacyAdminProducts(string $html): string
    {
        $html = preg_replace("/tab:\s*'[^']+'/", "tab: 'products'", $html, 1) ?? $html;

        return $this->stripLegacySidebar($html);
    }

    protected function stripLegacySidebar(string $html): string
    {
        $html = preg_replace('#<aside style="width: 260px;.*?</aside>#s', '', $html, 1) ?? $html;
        $html = str_replace(
            'min-height: 100vh; width: 100%; display: flex;',
            'min-height: 100vh; width: 100%; display: block;',
            $html
        );
        $html = str_replace(
            '<div style="flex: 1; padding: 32px 40px; min-width: 0;">',
            '<div style="width: 100%; padding: 0; min-width: 0;">',
            $html
        );

        return $html;
    }

    protected function resolveResourcePath(string $path): ?string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        if ($path === '') {
            return null;
        }

        $allowedRoots = [
            'support.js' => $this->workspaceRoot().DIRECTORY_SEPARATOR.'support.js',
            'image-slot.js' => $this->workspaceRoot().DIRECTORY_SEPARATOR.'image-slot.js',
        ];

        if (isset($allowedRoots[$path])) {
            return $allowedRoots[$path];
        }

        foreach (['assets/', 'uploads/'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                $candidate = $this->workspaceRoot().DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $path);

                return str_starts_with(realpath(dirname($candidate)) ?: '', realpath($this->workspaceRoot().DIRECTORY_SEPARATOR.trim($prefix, '/')) ?: '')
                    ? $candidate
                    : null;
            }
        }

        return null;
    }

    protected function workspaceRoot(): string
    {
        return dirname(base_path());
    }

    protected function editorDefinitions(string $page): ?array
    {
        $definitions = [
            'catalog' => [
                'sections' => [
                    [
                        'key' => 'catalog-header',
                        'title' => 'Заголовок и описание',
                        'fields' => [
                            ['type' => 'text', 'label' => 'Заголовок страницы', 'value' => 'Каталог продукции'],
                            ['type' => 'textarea', 'label' => 'Подзаголовок', 'value' => 'Твердосплавные сменные пластины и инструмент для станков с ЧПУ. Цены указаны за штуку, минимальная партия - 10 шт.'],
                        ],
                    ],
                    [
                        'key' => 'catalog-categories',
                        'title' => 'Категории',
                        'categories' => Category::query()
                            ->orderBy('sort_order')
                            ->orderBy('name')
                            ->get(['name'])
                            ->map(fn (Category $category) => ['label' => $category->name])
                            ->all(),
                    ],
                ],
            ],
            'delivery' => [
                'sections' => [
                    [
                        'title' => 'Страница доставки',
                        'fields' => [
                            ['type' => 'text', 'label' => 'Заголовок', 'value' => 'Доставка по России'],
                            ['type' => 'textarea', 'label' => 'Текст', 'value' => 'Отгружаем транспортными компаниями по всей России.'],
                        ],
                    ],
                ],
            ],
            'product' => [
                'sections' => [
                    [
                        'title' => 'Карточка товара',
                        'fields' => [
                            ['type' => 'text', 'label' => 'Количество фото по умолчанию', 'value' => '4'],
                        ],
                    ],
                ],
            ],
        ];

        return $definitions[$page] ?? null;
    }
}
