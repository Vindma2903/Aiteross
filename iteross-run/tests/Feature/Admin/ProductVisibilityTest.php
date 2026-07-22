<?php

namespace Tests\Feature\Admin;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_toggle_product_visibility_from_products_list(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000011',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-visibility-1@example.com',
            'password' => Hash::make('password'),
        ]);

        $product = Product::query()->create([
            'name' => 'Тестовая пластина',
            'slug' => 'testovaya-plastina-art-1',
            'sku' => 'ART-1',
            'description' => 'Описание',
            'price' => 1500,
            'stock_quantity' => 10,
            'is_visible' => true,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.products.visibility', $product), [
                'is_visible' => 0,
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'products']))
            ->assertSessionHas('status', 'Товар скрыт из каталога.');

        $this->assertFalse($product->fresh()->is_visible);
    }

    public function test_regular_user_cannot_toggle_product_visibility(): void
    {
        $user = User::query()->create([
            'name' => 'Regular User',
            'first_name' => 'Regular',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000012',
            'role' => User::ROLE_USER,
            'email' => 'user-visibility@example.com',
            'password' => Hash::make('password'),
        ]);

        $product = Product::query()->create([
            'name' => 'Тестовая пластина',
            'slug' => 'testovaya-plastina-art-2',
            'sku' => 'ART-2',
            'description' => 'Описание',
            'price' => 1500,
            'stock_quantity' => 10,
            'is_visible' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('admin.products.visibility', $product), [
                'is_visible' => 0,
            ]);

        $response->assertRedirect(route('account'));
        $this->assertTrue($product->fresh()->is_visible);
    }

    public function test_out_of_stock_product_can_be_made_visible_from_products_list(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000013',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-visibility-2@example.com',
            'password' => Hash::make('password'),
        ]);

        $product = Product::query()->create([
            'name' => 'Нет в наличии',
            'slug' => 'net-v-nalichii-art-3',
            'sku' => 'ART-3',
            'description' => 'Описание',
            'price' => 1500,
            'stock_quantity' => 0,
            'is_visible' => false,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.products.visibility', $product), [
                'is_visible' => 1,
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'products']))
            ->assertSessionHas('status', 'Товар показывается в каталоге.');

        $this->assertTrue($product->fresh()->is_visible);
    }

    public function test_catalog_shows_only_visible_products(): void
    {
        $category = Category::query()->create([
            'name' => 'Токарные пластины',
            'slug' => 'tokarnye-plastiny',
            'sort_order' => 10,
        ]);

        Product::query()->create([
            'name' => 'Видимый товар',
            'slug' => 'vidimyy-tovar-art-4',
            'sku' => 'ART-4',
            'description' => 'Описание',
            'price' => 2000,
            'stock_quantity' => 5,
            'is_visible' => true,
            'category_id' => $category->id,
        ]);

        Product::query()->create([
            'name' => 'Скрытый товар',
            'slug' => 'skrytyy-tovar-art-5',
            'sku' => 'ART-5',
            'description' => 'Описание',
            'price' => 2500,
            'stock_quantity' => 3,
            'is_visible' => false,
            'category_id' => $category->id,
        ]);

        $response = $this->get(route('catalog.index'));

        $response->assertOk();
        $response->assertSee('Видимый товар');
        $response->assertDontSee('Скрытый товар');
    }
}
