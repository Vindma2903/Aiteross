<?php

namespace Tests\Feature\Admin;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductAnalogsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_save_manual_analogs_and_order_for_product(): void
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $product = $this->createProduct('Main Product', 'MAIN-1', $category->id);
        $analogA = $this->createProduct('Analog A', 'AN-A', $category->id);
        $analogB = $this->createProduct('Analog B', 'AN-B', $category->id);

        $response = $this
            ->actingAs($admin)
            ->put(route('admin.products.update', $product), [
                'name' => $product->name,
                'sku' => $product->sku,
                'description' => $product->description,
                'price' => $product->price,
                'stock_quantity' => $product->stock_quantity,
                'unit_mode' => $product->unit_mode,
                'unit_multiplier' => $product->unit_multiplier,
                'category_id' => $product->category_id,
                'analog_mode' => Product::ANALOG_MODE_MANUAL,
                'manual_analog_ids' => [$analogB->id, $analogA->id],
                'is_visible' => 1,
            ]);

        $response->assertRedirect(route('admin.dashboard', ['section' => 'products']));

        $freshProduct = $product->fresh()->load('manualAnalogs');

        $this->assertSame(Product::ANALOG_MODE_MANUAL, $freshProduct->analog_mode);
        $this->assertSame(
            [$analogB->id, $analogA->id],
            $freshProduct->manualAnalogs->pluck('id')->all(),
        );
    }

    public function test_regular_user_cannot_update_product_analogs(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();
        $product = $this->createProduct('Main Product', 'MAIN-2', $category->id);
        $analog = $this->createProduct('Analog Only', 'AN-ONLY', $category->id);

        $response = $this
            ->actingAs($user)
            ->put(route('admin.products.update', $product), [
                'name' => $product->name,
                'sku' => $product->sku,
                'description' => $product->description,
                'price' => $product->price,
                'stock_quantity' => $product->stock_quantity,
                'unit_mode' => $product->unit_mode,
                'unit_multiplier' => $product->unit_multiplier,
                'category_id' => $product->category_id,
                'analog_mode' => Product::ANALOG_MODE_MANUAL,
                'manual_analog_ids' => [$analog->id],
                'is_visible' => 1,
            ]);

        $response->assertRedirect(route('account'));

        $freshProduct = $product->fresh()->load('manualAnalogs');
        $this->assertNotSame(Product::ANALOG_MODE_MANUAL, $freshProduct->analog_mode);
        $this->assertCount(0, $freshProduct->manualAnalogs);
    }

    public function test_product_page_shows_manual_analogs_in_saved_order(): void
    {
        $category = $this->createCategory();
        $product = $this->createProduct('Main Product', 'MAIN-3', $category->id, Product::ANALOG_MODE_MANUAL);
        $analogA = $this->createProduct('Analog A', 'AN-A2', $category->id);
        $analogB = $this->createProduct('Analog B', 'AN-B2', $category->id);
        $autoCandidate = $this->createProduct('Auto Candidate', 'AUTO-1', $category->id);

        $product->manualAnalogs()->sync([
            $analogB->id => ['sort_order' => 1],
            $analogA->id => ['sort_order' => 2],
        ]);

        $response = $this->get(route('catalog.products.show', ['slug' => $product->slug]));

        $response->assertOk();
        $response->assertSeeInOrder(['Analog B', 'Analog A']);
        $response->assertDontSee('Auto Candidate');
    }

    private function createAdmin(): User
    {
        return User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000101',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-analogs@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    private function createUser(): User
    {
        return User::query()->create([
            'name' => 'Regular User',
            'first_name' => 'Regular',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000102',
            'role' => User::ROLE_USER,
            'email' => 'user-analogs@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    private function createCategory(): Category
    {
        return Category::query()->create([
            'name' => 'Turning Inserts',
            'slug' => 'turning-inserts',
            'sort_order' => 10,
        ]);
    }

    private function createProduct(string $name, string $sku, ?int $categoryId, string $analogMode = Product::ANALOG_MODE_AUTOMATIC): Product
    {
        return Product::query()->create([
            'name' => $name,
            'slug' => strtolower($sku).'-slug',
            'sku' => $sku,
            'description' => 'Product description',
            'price' => 1500,
            'stock_quantity' => 10,
            'unit_mode' => Product::UNIT_MODE_PIECES,
            'unit_multiplier' => 1,
            'analog_mode' => $analogMode,
            'is_visible' => true,
            'category_id' => $categoryId,
        ]);
    }
}
