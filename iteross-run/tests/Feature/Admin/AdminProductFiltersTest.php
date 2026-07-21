<?php

namespace Tests\Feature\Admin;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_products_category_filter_shows_only_selected_category_products(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $turningCategory = Category::query()->create([
            'name' => 'Turning',
            'slug' => 'turning',
            'sort_order' => 10,
        ]);

        $millingCategory = Category::query()->create([
            'name' => 'Milling',
            'slug' => 'milling',
            'sort_order' => 20,
        ]);

        Product::query()->create([
            'name' => 'Turning Insert A',
            'slug' => 'turning-insert-a',
            'sku' => 'TURN-A',
            'description' => 'Turning product',
            'price' => 1000,
            'stock_quantity' => 5,
            'is_visible' => true,
            'category_id' => $turningCategory->id,
        ]);

        Product::query()->create([
            'name' => 'Milling Insert B',
            'slug' => 'milling-insert-b',
            'sku' => 'MILL-B',
            'description' => 'Milling product',
            'price' => 1200,
            'stock_quantity' => 8,
            'is_visible' => true,
            'category_id' => $millingCategory->id,
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('admin.dashboard', [
                'section' => 'products',
                'category' => (string) $turningCategory->id,
            ]));

        $response->assertOk();
        $response->assertSee('Turning Insert A');
        $response->assertDontSee('Milling Insert B');
    }
}
