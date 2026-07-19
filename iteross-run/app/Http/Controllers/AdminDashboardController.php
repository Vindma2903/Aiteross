<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateCatalogCategoriesRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminDashboardController extends Controller
{
    private const STATIC_PAGES = [
        'home' => ['label' => 'Главная', 'file' => 'Главная АЙТЕРОСС.dc.html'],
        'catalog' => ['label' => 'Каталог', 'file' => 'Каталог.dc.html'],
        'delivery' => ['label' => 'Доставка', 'file' => 'Доставка.dc.html'],
        'product' => ['label' => 'Карточка товара', 'file' => 'Товар.dc.html'],
        'account' => ['label' => 'Личный кабинет', 'file' => 'Личный кабинет.dc.html'],
        'auth' => ['label' => 'Авторизация', 'file' => 'Авторизация.dc.html'],
        'register' => ['label' => 'Регистрация', 'file' => 'Регистрация.dc.html'],
        'admin-login' => ['label' => 'Вход администратора', 'file' => 'Вход администратора.dc.html'],
        'admin-legacy' => ['label' => 'Старая админка', 'file' => 'Админка.dc.html'],
    ];

    public function index(Request $request): View
    {
        $selectedPage = $request->string('page')->toString();
        $selectedSection = $request->string('section')->toString();
        $productSearch = trim($request->string('search')->toString());
        $productCategory = $request->string('category')->toString();

        if (! in_array($selectedSection, ['pages', 'orders', 'products'], true)) {
            $selectedSection = 'pages';
        }

        if (! array_key_exists($selectedPage, self::STATIC_PAGES)) {
            $selectedPage = 'home';
        }

        $productsQuery = Product::query()
            ->with('category')
            ->orderBy('name');

        if ($productSearch !== '') {
            $productsQuery->where(function ($query) use ($productSearch) {
                $query
                    ->where('name', 'like', '%'.$productSearch.'%')
                    ->orWhere('sku', 'like', '%'.$productSearch.'%');
            });
        }

        if ($productCategory !== '' && ctype_digit($productCategory)) {
            $productsQuery->where('category_id', (int) $productCategory);
        }

        return view('admin.dashboard', [
            'userCount' => User::query()->where('role', User::ROLE_USER)->count(),
            'adminCount' => User::query()->where('role', User::ROLE_ADMIN)->count(),
            'categories' => Category::query()->orderBy('sort_order')->orderBy('name')->get(),
            'products' => $productsQuery->get(),
            'productSearch' => $productSearch,
            'productCategory' => $productCategory,
            'staticPages' => self::STATIC_PAGES,
            'selectedPage' => $selectedPage,
            'selectedPageMeta' => self::STATIC_PAGES[$selectedPage],
            'selectedSection' => $selectedSection,
        ]);
    }

    public function editor(string $page): View
    {
        abort_unless(isset(self::STATIC_PAGES[$page]), 404);

        return view('admin.page-editor', [
            'userCount' => User::query()->where('role', User::ROLE_USER)->count(),
            'adminCount' => User::query()->where('role', User::ROLE_ADMIN)->count(),
            'staticPages' => self::STATIC_PAGES,
            'selectedSection' => 'pages',
            'selectedEditor' => $page,
            'selectedEditorMeta' => self::STATIC_PAGES[$page],
            'editorDefinition' => $this->editorDefinitions($page),
        ]);
    }

    public function updateCatalogCategories(UpdateCatalogCategoriesRequest $request): RedirectResponse
    {
        $categories = collect($request->validated('categories'))
            ->map(fn (array $category, int $index) => [
                'name' => trim($category['name']),
                'slug' => Str::slug($category['name']),
                'sort_order' => $index + 1,
            ])
            ->filter(fn (array $category) => $category['name'] !== '' && $category['slug'] !== '')
            ->values();

        $keptIds = [];

        foreach ($categories as $categoryData) {
            $category = Category::query()->updateOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name' => $categoryData['name'],
                    'sort_order' => $categoryData['sort_order'],
                ],
            );

            $keptIds[] = $category->id;
        }

        $categoriesToDelete = Category::query();

        if ($keptIds !== []) {
            $categoriesToDelete->whereNotIn('id', $keptIds);
        }

        $categoriesToDelete->delete();

        return redirect()
            ->route('admin.pages.editor', ['page' => 'catalog'])
            ->with('status', 'Категории каталога сохранены и уже связаны с фронтом.');
    }

    public function storeProduct(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'].'-'.$data['sku']);

        Product::query()->create($data);

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар создан.');
    }

    public function updateProduct(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'].'-'.$data['sku']);

        $product->update($data);

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар обновлён.');
    }

    public function destroyProduct(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.dashboard', ['section' => 'products'])
            ->with('status', 'Товар удалён.');
    }

    public function preview(string $page): Response
    {
        abort_unless(isset(self::STATIC_PAGES[$page]), 404);

        $filePath = $this->workspaceRoot().DIRECTORY_SEPARATOR.self::STATIC_PAGES[$page]['file'];
        abort_unless(File::exists($filePath), 404);

        $html = File::get($filePath);
        $html = $this->rewriteStaticHtml($html);

        return response($html, 200)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function resource(string $path): BinaryFileResponse
    {
        $resolvedPath = $this->resolveResourcePath($path);
        abort_unless($resolvedPath !== null && File::exists($resolvedPath), 404);

        return response()->file($resolvedPath);
    }

    public function legacyEditor(string $page): Response
    {
        abort_unless(isset(self::STATIC_PAGES[$page]), 404);

        $html = $this->legacyAdminHtml();
        $html = $this->patchLegacyAdminPageEditor($html, $page);

        return response($html, 200)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function legacyProducts(): Response
    {
        $html = $this->legacyAdminHtml();
        $html = $this->patchLegacyAdminProducts($html);

        return response($html, 200)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    private function rewriteStaticHtml(string $html): string
    {
        $html = str_replace('./support.js', route('admin.static.resource', ['path' => 'support.js']), $html);
        $html = str_replace('./image-slot.js', route('admin.static.resource', ['path' => 'image-slot.js']), $html);
        $html = str_replace('./assets/', route('admin.static.resource', ['path' => 'assets']).'/', $html);
        $html = str_replace('./uploads/', route('admin.static.resource', ['path' => 'uploads']).'/', $html);

        foreach (self::STATIC_PAGES as $slug => $meta) {
            $previewUrl = route('admin.static.preview', ['page' => $slug]);
            $html = str_replace('./'.$meta['file'], $previewUrl, $html);
            $html = str_replace($meta['file'], $previewUrl, $html);
        }

        return $html;
    }

    private function legacyAdminHtml(): string
    {
        $filePath = $this->workspaceRoot().DIRECTORY_SEPARATOR.'Админка.dc.html';
        abort_unless(File::exists($filePath), 404);

        return $this->rewriteStaticHtml(File::get($filePath));
    }

    private function patchLegacyAdminPageEditor(string $html, string $page): string
    {
        $html = preg_replace("/tab:\s*'[^']+'/", "tab: 'page'", $html, 1) ?? $html;
        $html = preg_replace("/selectedPageId:\s*'[^']+'/", "selectedPageId: '".$page."'", $html, 1) ?? $html;

        return $this->stripLegacySidebar($html);
    }

    private function patchLegacyAdminProducts(string $html): string
    {
        $html = preg_replace("/tab:\s*'[^']+'/", "tab: 'products'", $html, 1) ?? $html;

        return $this->stripLegacySidebar($html);
    }

    private function stripLegacySidebar(string $html): string
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

    private function resolveResourcePath(string $path): ?string
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

    private function workspaceRoot(): string
    {
        return dirname(base_path());
    }

    private function editorDefinitions(string $page): ?array
    {
        $definitions = [
            'home' => [
                'sections' => [
                    [
                        'title' => 'Первый экран',
                        'fields' => [
                            ['type' => 'text', 'label' => 'Заголовок', 'value' => 'Твердосплавные пластины для станков с ЧПУ'],
                            ['type' => 'textarea', 'label' => 'Подзаголовок', 'value' => 'Прямые поставки, подбор аналогов и стабильные партии от 10 штук - для производств, которым важна предсказуемость.'],
                            ['type' => 'text', 'label' => 'Текст кнопки CTA', 'value' => 'Получить предложение'],
                        ],
                    ],
                    [
                        'title' => 'Преимущества в hero',
                        'fields' => [
                            ['type' => 'textarea', 'label' => 'Пункты преимуществ', 'value' => "Работаем с юридическими лицами\nМинимальная партия от 10 шт.\nПодбор аналогов\nПоставка по России"],
                        ],
                    ],
                    [
                        'title' => 'FAQ',
                        'fields' => [
                            ['type' => 'textarea', 'label' => 'Вопрос 1', 'value' => 'Какая минимальная партия заказа?'],
                            ['type' => 'textarea', 'label' => 'Ответ 1', 'value' => 'Минимальная партия - 10 пластин по одному артикулу.'],
                            ['type' => 'textarea', 'label' => 'Вопрос 2', 'value' => 'Как оформить заказ?'],
                            ['type' => 'textarea', 'label' => 'Ответ 2', 'value' => 'Выбираете нужные позиции в каталоге и отправляете заявку через форму на сайте.'],
                        ],
                    ],
                ],
            ],
            'catalog' => [
                'sections' => [
                    [
                        'key' => 'catalog-header',
                        'title' => 'Заголовок и описание',
                        'fields' => [
                            ['type' => 'text', 'label' => 'Заголовок страницы', 'value' => 'Каталог продукции'],
                            ['type' => 'textarea', 'label' => 'Подзаголовок', 'value' => 'Твердосплавные сменные пластины для станков с ЧПУ. Цены указаны за штуку, минимальная партия - 10 шт.'],
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
                    [
                        'key' => 'catalog-filters',
                        'title' => 'Фильтры сайдбара',
                        'fields' => [
                            ['type' => 'textarea', 'label' => 'Радиус при вершине RE', 'value' => "0.2\n0.4\n0.8\n1.2\n1.6\n2.4"],
                            ['type' => 'textarea', 'label' => 'Размер пластины', 'value' => "09\n12\n16\n19\n25"],
                            ['type' => 'textarea', 'label' => 'Сплав пластины', 'value' => "GPT6130\nGS3115\nGS3125\nGS3210\nGS3220"],
                        ],
                    ],
                ],
            ],
            'product' => [
                'sections' => [
                    [
                        'title' => 'Структура галереи',
                        'fields' => [
                            ['type' => 'text', 'label' => 'Количество фотографий по умолчанию', 'value' => '4'],
                        ],
                    ],
                    [
                        'title' => 'Переключатели блоков',
                        'toggles' => [
                            'Наличие на складе',
                            'Блок «Аналоги»',
                            'Блок «Также покупают»',
                            'Кнопка «В корзину» и количество',
                            'Кнопка «Избранное»',
                            'Обрабатываемый материал (ISO)',
                            'Тип обработки',
                        ],
                    ],
                    [
                        'title' => 'Строки характеристик',
                        'toggles' => [
                            'Бренд',
                            'Геометрия',
                            'Форма пластины',
                            'Размер',
                            'Радиус при вершине RE',
                            'Задний угол',
                            'Конструкция пластины',
                            'Материал пластины',
                            'Сплав пластины',
                            'Стружколом',
                        ],
                    ],
                ],
            ],
            'delivery' => [
                'sections' => [
                    [
                        'title' => 'Настройки страницы доставки',
                        'fields' => [
                            ['type' => 'text', 'label' => 'Заголовок', 'value' => 'Доставка по России'],
                            ['type' => 'textarea', 'label' => 'Основной текст', 'value' => 'Отгружаем транспортными компаниями по всей России. Сроки зависят от региона и выбранного способа доставки.'],
                            ['type' => 'textarea', 'label' => 'Преимущества', 'value' => "Отправка в любой регион\nПодбор удобной ТК\nОперативная отгрузка со склада"],
                        ],
                    ],
                ],
            ],
        ];

        return $definitions[$page] ?? null;
    }
}
