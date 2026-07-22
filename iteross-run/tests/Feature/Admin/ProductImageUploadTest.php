<?php

namespace Tests\Feature\Admin;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    private const TINY_PNG = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9WlAbwAAAABJRU5ErkJggg==';

    public function test_admin_can_create_product_with_uploaded_image(): void
    {
        Storage::fake('public');

        $admin = User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000001',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-image-1@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Тестовый товар',
                'sku' => 'TEST-SKU-001',
                'description' => 'Описание товара',
                'price' => 1000,
                'stock_quantity' => 5,
                'is_visible' => 1,
                'image' => UploadedFile::fake()->createWithContent('product.png', base64_decode(self::TINY_PNG)),
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'products']))
            ->assertSessionHas('status', 'Товар создан.');

        $product = Product::query()->where('sku', 'TEST-SKU-001')->first();

        $this->assertNotNull($product);
        $this->assertNotNull($product->image);
        $this->assertStringStartsWith('/storage/product-images/', $product->image);

        Storage::disk('public')->assertExists(str_replace('/storage/', '', $product->image));
    }

    public function test_admin_can_create_product_with_existing_uploaded_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('product-images/existing-product.jpg', 'fake-image-content');

        $admin = User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000002',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-image-2@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Товар с готовым фото',
                'sku' => 'TEST-SKU-EXISTING-001',
                'description' => 'Описание товара',
                'price' => 1500,
                'stock_quantity' => 4,
                'is_visible' => 1,
                'existing_image' => '/storage/product-images/existing-product.jpg',
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'products']))
            ->assertSessionHas('status', 'Товар создан.');

        $product = Product::query()->where('sku', 'TEST-SKU-EXISTING-001')->first();

        $this->assertNotNull($product);
        $this->assertSame('/storage/product-images/existing-product.jpg', $product->image);
    }

    public function test_product_with_zero_stock_can_still_be_created_visible(): void
    {
        Storage::fake('public');

        $admin = User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000003',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-image-3@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Позиция под заказ',
                'sku' => 'TEST-SKU-002',
                'description' => 'Описание товара',
                'price' => 1000,
                'stock_quantity' => 0,
                'is_visible' => 1,
                'image' => UploadedFile::fake()->createWithContent('product-2.png', base64_decode(self::TINY_PNG)),
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'products']))
            ->assertSessionHas('status', 'Товар создан.');

        $product = Product::query()->where('sku', 'TEST-SKU-002')->first();

        $this->assertNotNull($product);
        $this->assertTrue($product->is_visible);
        $this->assertSame(0, $product->stock_quantity);
    }
}
