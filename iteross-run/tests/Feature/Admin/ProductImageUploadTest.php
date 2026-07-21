<?php

namespace Tests\Feature\Admin;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product_with_uploaded_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
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
                'image' => UploadedFile::fake()->image('product.jpg'),
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

    public function test_product_with_zero_stock_is_created_hidden_even_if_visibility_is_enabled(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Скрытый по остатку товар',
                'sku' => 'TEST-SKU-002',
                'description' => 'Описание товара',
                'price' => 1000,
                'stock_quantity' => 0,
                'is_visible' => 1,
                'image' => UploadedFile::fake()->image('product-2.jpg'),
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'products']))
            ->assertSessionHas('status', 'Товар создан.');

        $product = Product::query()->where('sku', 'TEST-SKU-002')->first();

        $this->assertNotNull($product);
        $this->assertFalse($product->is_visible);
        $this->assertSame(0, $product->stock_quantity);
    }
}
