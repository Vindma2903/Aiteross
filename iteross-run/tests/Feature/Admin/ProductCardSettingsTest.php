<?php

namespace Tests\Feature\Admin;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\CatalogFilterGroup;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\CatalogFilterOption;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductCardSettingsTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function admin(): User
    {
        static $counter = 0;
        $counter++;

        return User::query()->create([
            'name'       => 'Admin',
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'company'    => 'Iteross',
            'phone'      => '+7900000' . str_pad($counter, 4, '0', STR_PAD_LEFT),
            'role'       => User::ROLE_ADMIN,
            'email'      => "admin-card-{$counter}@example.com",
            'password'   => Hash::make('password'),
        ]);
    }

    private function regularUser(): User
    {
        static $counter = 0;
        $counter++;

        return User::query()->create([
            'name'       => 'User',
            'first_name' => 'Regular',
            'last_name'  => 'User',
            'company'    => 'Iteross',
            'phone'      => '+7911000' . str_pad($counter, 4, '0', STR_PAD_LEFT),
            'role'       => User::ROLE_USER,
            'email'      => "user-card-{$counter}@example.com",
            'password'   => Hash::make('password'),
        ]);
    }

    private function validSettings(array $overrides = []): array
    {
        return array_replace_recursive([
            'photo_count' => 1,
            'blocks' => [
                'show_stock'            => true,
                'show_analogs'          => true,
                'show_also_bought'      => false,
                'show_cart'             => true,
                'show_wish'             => true,
                'show_materials'        => true,
                'show_processing_types' => true,
            ],
            'rows' => [
                'brand'          => true,
                'geometry'       => true,
                'shape'          => true,
                'size'           => true,
                'radius'         => true,
                'back_angle'     => true,
                'construction'   => true,
                'plate_material' => true,
                'alloy'          => true,
                'chipbreaker'    => true,
            ],
        ], $overrides);
    }

    private function saveSettings(array $settings): void
    {
        Storage::disk('local')->put(
            'page-content/product.json',
            json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        );
    }

    private function createProduct(array $attrs = []): Product
    {
        static $counter = 0;
        $counter++;

        return Product::query()->create(array_merge([
            'name'           => 'Тестовая пластина',
            'slug'           => 'test-card-product-' . $counter,
            'sku'            => 'TCP-' . $counter,
            'description'    => 'Описание',
            'price'          => 1000,
            'stock_quantity' => 5,
            'is_visible'     => true,
        ], $attrs));
    }

    // -------------------------------------------------------------------------
    // 1. Сохранение настроек через HTTP
    // -------------------------------------------------------------------------

    public function test_admin_can_save_all_block_toggles(): void
    {
        Storage::fake('local');

        $settings = $this->validSettings([
            'blocks' => [
                'show_stock'            => false,
                'show_analogs'          => false,
                'show_also_bought'      => true,
                'show_cart'             => false,
                'show_wish'             => false,
                'show_materials'        => false,
                'show_processing_types' => false,
            ],
        ]);

        $response = $this
            ->actingAs($this->admin())
            ->post(route('admin.pages.update', ['page' => 'product']), $settings);

        $response->assertRedirect(route('admin.pages.editor', ['page' => 'product']));
        $response->assertSessionHas('status', 'Настройки карточки товара сохранены.');

        Storage::disk('local')->assertExists('page-content/product.json');

        $stored = json_decode(Storage::disk('local')->get('page-content/product.json'), true);

        $this->assertFalse((bool) $stored['blocks']['show_stock']);
        $this->assertFalse((bool) $stored['blocks']['show_analogs']);
        $this->assertTrue((bool) $stored['blocks']['show_also_bought']);
        $this->assertFalse((bool) $stored['blocks']['show_cart']);
        $this->assertFalse((bool) $stored['blocks']['show_wish']);
        $this->assertFalse((bool) $stored['blocks']['show_materials']);
        $this->assertFalse((bool) $stored['blocks']['show_processing_types']);
    }

    public function test_admin_can_save_all_row_toggles(): void
    {
        Storage::fake('local');

        $settings = $this->validSettings([
            'rows' => [
                'brand'          => false,
                'geometry'       => false,
                'shape'          => false,
                'size'           => false,
                'radius'         => false,
                'back_angle'     => false,
                'construction'   => false,
                'plate_material' => false,
                'alloy'          => false,
                'chipbreaker'    => false,
            ],
        ]);

        $response = $this
            ->actingAs($this->admin())
            ->post(route('admin.pages.update', ['page' => 'product']), $settings);

        $response->assertRedirect(route('admin.pages.editor', ['page' => 'product']));

        $stored = json_decode(Storage::disk('local')->get('page-content/product.json'), true);

        foreach (array_keys($settings['rows']) as $key) {
            $this->assertFalse((bool) $stored['rows'][$key], "Row '{$key}' should be saved as false");
        }
    }

    public function test_regular_user_cannot_save_product_card_settings(): void
    {
        Storage::fake('local');

        $response = $this
            ->actingAs($this->regularUser())
            ->post(route('admin.pages.update', ['page' => 'product']), $this->validSettings());

        $response->assertRedirect(route('account'));
        Storage::disk('local')->assertMissing('page-content/product.json');
    }

    public function test_unauthenticated_user_cannot_save_product_card_settings(): void
    {
        Storage::fake('local');

        $response = $this->post(
            route('admin.pages.update', ['page' => 'product']),
            $this->validSettings(),
        );

        $response->assertRedirect();
        Storage::disk('local')->assertMissing('page-content/product.json');
    }

    // -------------------------------------------------------------------------
    // 2. Репозиторий: чтение и запись
    // -------------------------------------------------------------------------

    public function test_repository_returns_defaults_when_no_file_exists(): void
    {
        Storage::fake('local');

        $response = $this
            ->actingAs($this->admin())
            ->get(route('admin.pages.editor', ['page' => 'product']));

        $response->assertOk();
        // Страница редактора загружается без ошибок — значит defaults применились
    }

    public function test_repository_merges_stored_settings_with_defaults(): void
    {
        Storage::fake('local');

        // Сохранить неполный файл настроек (без некоторых новых ключей)
        Storage::disk('local')->put(
            'page-content/product.json',
            json_encode([
                'photo_count' => 3,
                'blocks' => ['show_stock' => false],
                // rows отсутствуют
            ]),
        );

        $response = $this
            ->actingAs($this->admin())
            ->get(route('admin.pages.editor', ['page' => 'product']));

        $response->assertOk();
        $response->assertViewHas('productPageSettings');

        $settings = $response->viewData('productPageSettings');

        // Явно сохранённое значение
        $this->assertFalse((bool) data_get($settings, 'blocks.show_stock'));
        // photo_count из файла
        $this->assertSame(3, (int) data_get($settings, 'photo_count'));
        // Строки заполнены из defaults
        $this->assertTrue((bool) data_get($settings, 'rows.brand'));
        $this->assertTrue((bool) data_get($settings, 'rows.alloy'));
        // Не сохранённые блоки тоже из defaults
        $this->assertTrue((bool) data_get($settings, 'blocks.show_analogs'));
    }

    // -------------------------------------------------------------------------
    // 3. Блоки карточки: влияние на публичную страницу
    // -------------------------------------------------------------------------

    public function test_show_stock_false_hides_stock_label_on_product_page(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings(['blocks' => ['show_stock' => false, 'show_analogs' => true, 'show_also_bought' => false, 'show_cart' => true, 'show_wish' => true, 'show_materials' => true, 'show_processing_types' => true]]));

        $product = $this->createProduct(['stock_quantity' => 10]);

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();
        // CSS содержит .stock-label { }, поэтому проверяем конкретный HTML-элемент
        $response->assertDontSee('class="stock-label"', false);
    }

    public function test_show_stock_true_shows_stock_label_on_product_page(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings());

        $product = $this->createProduct(['stock_quantity' => 10]);

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();
        $response->assertSee('class="stock-label"', false);
    }

    public function test_show_cart_false_hides_cart_button_on_product_page(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings([
            'blocks' => ['show_stock' => true, 'show_analogs' => true, 'show_also_bought' => false, 'show_cart' => false, 'show_wish' => false, 'show_materials' => true, 'show_processing_types' => true],
        ]));

        $product = $this->createProduct();

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();
        // class="buy-button" встречается только в HTML-элементе, CSS использует .buy-button (без class=)
        $response->assertDontSee('class="buy-button"', false);
    }

    public function test_show_cart_true_shows_cart_button_on_product_page(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings());

        $product = $this->createProduct();

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();
        $response->assertSee('class="buy-button"', false);
    }

    public function test_show_wish_false_hides_favorite_button_on_product_page(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings([
            'blocks' => ['show_stock' => true, 'show_analogs' => true, 'show_also_bought' => false, 'show_cart' => true, 'show_wish' => false, 'show_materials' => true, 'show_processing_types' => true],
        ]));

        $product = $this->createProduct();

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();
        // CSS содержит .favorite-button { }, проверяем форму избранного
        $response->assertDontSee('class="favorite-form"', false);
    }

    public function test_show_wish_true_shows_favorite_button_on_product_page(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings());

        $product = $this->createProduct();

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();
        $response->assertSee('class="favorite-form"', false);
    }

    public function test_show_analogs_false_hides_analogs_section_even_when_analogs_exist(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings([
            'blocks' => ['show_stock' => true, 'show_analogs' => false, 'show_also_bought' => false, 'show_cart' => true, 'show_wish' => true, 'show_materials' => true, 'show_processing_types' => true],
        ]));

        $category = Category::query()->create([
            'name'       => 'Токарные пластины',
            'slug'       => 'tokarnye-plastiny-test-analogs',
            'sort_order' => 1,
        ]);

        $product = $this->createProduct(['category_id' => $category->id]);

        // Создаём аналог в той же категории
        $this->createProduct(['category_id' => $category->id]);

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();
        // CSS содержит .analogs-section { }, проверяем HTML-элемент секции
        $response->assertDontSee('<section class="container analogs-section">', false);
    }

    public function test_show_analogs_true_shows_analogs_section_when_analogs_exist(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings());

        $category = Category::query()->create([
            'name'       => 'Токарные пластины',
            'slug'       => 'tokarnye-plastiny-test-analogs-visible',
            'sort_order' => 1,
        ]);

        $product = $this->createProduct(['category_id' => $category->id]);
        $this->createProduct(['category_id' => $category->id]);

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();
        $response->assertSee('<section class="container analogs-section">', false);
    }

    // -------------------------------------------------------------------------
    // 4. Строки характеристик: фильтрация в контроллере
    // -------------------------------------------------------------------------

    public function test_disabled_spec_row_is_excluded_from_visible_filter_specs(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings([
            'rows' => [
                'brand'          => false,
                'geometry'       => true,
                'shape'          => true,
                'size'           => true,
                'radius'         => true,
                'back_angle'     => true,
                'construction'   => true,
                'plate_material' => true,
                'alloy'          => true,
                'chipbreaker'    => true,
            ],
        ]));

        $product = $this->createProduct();
        $group   = CatalogFilterGroup::query()->create(['name' => 'Бренд', 'slug' => 'brand', 'is_enabled' => true]);
        $option  = CatalogFilterOption::query()->create(['group_id' => $group->id, 'name' => 'Sandvik', 'slug' => 'sandvik']);
        $product->filterOptions()->attach($option->id);

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();
        $response->assertViewHas('visibleFilterSpecs');

        $specs = $response->viewData('visibleFilterSpecs');
        $groupNames = $specs->pluck('name')->toArray();

        $this->assertNotContains('Бренд', $groupNames, 'Строка «Бренд» должна быть скрыта');
    }

    public function test_enabled_spec_row_appears_in_visible_filter_specs(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings());

        $product = $this->createProduct();
        $group   = CatalogFilterGroup::query()->create(['name' => 'Бренд', 'slug' => 'brand-enabled-test', 'is_enabled' => true]);
        $option  = CatalogFilterOption::query()->create(['group_id' => $group->id, 'name' => 'Mitsubishi', 'slug' => 'mitsubishi']);
        $product->filterOptions()->attach($option->id);

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();

        $specs = $response->viewData('visibleFilterSpecs');
        $groupNames = $specs->pluck('name')->toArray();

        $this->assertContains('Бренд', $groupNames, 'Строка «Бренд» должна отображаться');
    }

    public function test_show_materials_false_excludes_materials_spec_group(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings([
            'blocks' => ['show_stock' => true, 'show_analogs' => true, 'show_also_bought' => false, 'show_cart' => true, 'show_wish' => true, 'show_materials' => false, 'show_processing_types' => true],
        ]));

        $product = $this->createProduct();
        $group   = CatalogFilterGroup::query()->create(['name' => 'Обрабатываемый материал (ISO)', 'slug' => 'iso-material-test', 'is_enabled' => true]);
        $option  = CatalogFilterOption::query()->create(['group_id' => $group->id, 'name' => 'P', 'slug' => 'iso-p-test']);
        $product->filterOptions()->attach($option->id);

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();

        $specs      = $response->viewData('visibleFilterSpecs');
        $groupNames = $specs->pluck('name')->toArray();

        $this->assertNotContains('Обрабатываемый материал (ISO)', $groupNames);
    }

    public function test_show_processing_types_false_excludes_processing_types_spec_group(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings([
            'blocks' => ['show_stock' => true, 'show_analogs' => true, 'show_also_bought' => false, 'show_cart' => true, 'show_wish' => true, 'show_materials' => true, 'show_processing_types' => false],
        ]));

        $product = $this->createProduct();
        $group   = CatalogFilterGroup::query()->create(['name' => 'Тип обработки', 'slug' => 'processing-type-test', 'is_enabled' => true]);
        $option  = CatalogFilterOption::query()->create(['group_id' => $group->id, 'name' => 'Черновая', 'slug' => 'rough-test']);
        $product->filterOptions()->attach($option->id);

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();

        $specs      = $response->viewData('visibleFilterSpecs');
        $groupNames = $specs->pluck('name')->toArray();

        $this->assertNotContains('Тип обработки', $groupNames);
    }

    // -------------------------------------------------------------------------
    // 5. Все строки можно отключить одновременно
    // -------------------------------------------------------------------------

    public function test_all_spec_rows_disabled_results_in_empty_visible_specs(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings([
            'rows' => array_fill_keys(
                ['brand', 'geometry', 'shape', 'size', 'radius', 'back_angle', 'construction', 'plate_material', 'alloy', 'chipbreaker'],
                false,
            ),
            'blocks' => ['show_stock' => true, 'show_analogs' => true, 'show_also_bought' => false, 'show_cart' => true, 'show_wish' => true, 'show_materials' => false, 'show_processing_types' => false],
        ]));

        $product = $this->createProduct();

        // Добавляем по одной опции на каждый тип группы
        foreach ([
            'Бренд'          => 'brand-all',
            'Геометрия'      => 'geometry-all',
            'Форма пластины' => 'shape-all',
            'Размер'         => 'size-all',
        ] as $groupName => $slug) {
            $group  = CatalogFilterGroup::query()->create(['name' => $groupName, 'slug' => $slug, 'is_enabled' => true]);
            $option = CatalogFilterOption::query()->create(['group_id' => $group->id, 'name' => 'Значение', 'slug' => $slug . '-val']);
            $product->filterOptions()->attach($option->id);
        }

        $response = $this->get(route('catalog.products.show', $product->slug));

        $response->assertOk();

        $specs = $response->viewData('visibleFilterSpecs');
        $this->assertCount(0, $specs, 'Все строки характеристик должны быть скрыты');
    }

    // -------------------------------------------------------------------------
    // 6. Редактор настроек отображает текущие значения
    // -------------------------------------------------------------------------

    public function test_editor_shows_saved_settings(): void
    {
        Storage::fake('local');
        $this->saveSettings($this->validSettings([
            'blocks' => ['show_stock' => false, 'show_analogs' => false, 'show_also_bought' => false, 'show_cart' => false, 'show_wish' => false, 'show_materials' => false, 'show_processing_types' => false],
        ]));

        $response = $this
            ->actingAs($this->admin())
            ->get(route('admin.pages.editor', ['page' => 'product']));

        $response->assertOk();
        $response->assertViewHas('productPageSettings');

        $settings = $response->viewData('productPageSettings');

        $this->assertFalse((bool) data_get($settings, 'blocks.show_stock'));
        $this->assertFalse((bool) data_get($settings, 'blocks.show_analogs'));
        $this->assertFalse((bool) data_get($settings, 'blocks.show_cart'));
        $this->assertFalse((bool) data_get($settings, 'blocks.show_wish'));
    }
}
