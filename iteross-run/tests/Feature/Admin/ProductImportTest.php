<?php

namespace Tests\Feature\Admin;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_import_products_from_csv_and_update_existing_rows(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000021',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-import@example.com',
            'password' => Hash::make('password'),
        ]);

        Product::query()->create([
            'name' => 'Старое имя',
            'slug' => 'staroe-imya-sku-100',
            'sku' => 'SKU-100',
            'description' => 'Старое описание',
            'price' => 100,
            'stock_quantity' => 1,
            'is_visible' => false,
        ]);

        $csv = implode("\n", [
            'Название;Артикул;Категория;Цена;Остаток;Единица;Множитель;Описание;Видимость;Фото',
            'Обновлённый товар;SKU-100;Токарные пластины;2500;0;упаковки;10;Новое описание;1;existing-image.jpg',
            'Новый товар;SKU-200;Фрезерные пластины;3200;15;штуки;1;Описание новой позиции;1;https://example.com/product-200.jpg',
        ]);

        $file = UploadedFile::fake()->createWithContent('products.csv', $csv);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.products.import'), [
                'file' => $file,
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'products']))
            ->assertSessionHas('status', 'Импорт товаров завершён (создано: 1, обновлено: 1).');

        $updatedProduct = Product::query()->where('sku', 'SKU-100')->first();
        $createdProduct = Product::query()->where('sku', 'SKU-200')->first();

        $this->assertNotNull($updatedProduct);
        $this->assertSame('Обновлённый товар', $updatedProduct->name);
        $this->assertSame(2500, $updatedProduct->price);
        $this->assertSame(0, $updatedProduct->stock_quantity);
        $this->assertTrue($updatedProduct->is_visible);
        $this->assertSame('/storage/product-images/existing-image.jpg', $updatedProduct->image);
        $this->assertSame('packs', $updatedProduct->unit_mode);
        $this->assertSame(10, $updatedProduct->unit_multiplier);

        $this->assertNotNull($createdProduct);
        $this->assertSame('Новый товар', $createdProduct->name);
        $this->assertSame(3200, $createdProduct->price);
        $this->assertSame(15, $createdProduct->stock_quantity);
        $this->assertTrue($createdProduct->is_visible);
        $this->assertSame('https://example.com/product-200.jpg', $createdProduct->image);
        $this->assertSame('pieces', $createdProduct->unit_mode);
        $this->assertSame(1, $createdProduct->unit_multiplier);

        $this->assertTrue(Category::query()->where('name', 'Токарные пластины')->exists());
        $this->assertTrue(Category::query()->where('name', 'Фрезерные пластины')->exists());
    }
}
