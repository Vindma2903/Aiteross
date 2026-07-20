<?php

namespace Tests\Feature\Favorites;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Favorites\Infrastructure\Persistence\Eloquent\FavoriteItem;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FavoriteFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_add_product_to_favorites(): void
    {
        $product = Product::query()->create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'sku' => 'TP-001',
            'description' => 'Test description',
            'price' => 1000,
        ]);

        $response = $this->post(route('favorites.toggle', $product));

        $response->assertRedirect();
        $response->assertSessionHas('status', 'Товар добавлен в избранное.');

        $sessionId = session()->getId();

        $this->assertDatabaseHas('favorite_items', [
            'product_id' => $product->id,
            'session_id' => $sessionId,
            'user_id' => null,
        ]);

        $favoritesPage = $this->get(route('favorites.index'));

        $favoritesPage->assertOk();
        $favoritesPage->assertSee('Test Product');
    }

    public function test_guest_favorites_are_merged_into_user_after_login(): void
    {
        $product = Product::query()->create([
            'name' => 'Merge Product',
            'slug' => 'merge-product',
            'sku' => 'TP-002',
            'description' => 'Merge description',
            'price' => 2000,
        ]);

        $guestSessionId = session()->getId();

        FavoriteItem::query()->create([
            'session_id' => $guestSessionId,
            'product_id' => $product->id,
        ]);

        $user = User::query()->create([
            'name' => 'Favorite User',
            'first_name' => 'Favorite',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+7 (999) 111-22-33',
            'email' => 'favorite@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        $this->assertDatabaseHas('favorite_items', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseMissing('favorite_items', [
            'product_id' => $product->id,
            'session_id' => $guestSessionId,
        ]);

        $favoritesPage = $this->get(route('favorites.index'));

        $favoritesPage->assertOk();
        $favoritesPage->assertSee('Merge Product');
    }

    public function test_catalog_can_be_filtered_by_category_and_shows_breadcrumbs(): void
    {
        $targetCategory = Category::query()->create([
            'name' => 'Токарные пластины',
            'slug' => 'tokarnye-plastiny',
            'sort_order' => 1,
        ]);

        $otherCategory = Category::query()->create([
            'name' => 'Фрезерные пластины',
            'slug' => 'frezernye-plastiny',
            'sort_order' => 2,
        ]);

        Product::query()->create([
            'name' => 'Turning Product',
            'slug' => 'turning-product',
            'sku' => 'TP-100',
            'description' => 'Turning description',
            'price' => 1000,
            'category_id' => $targetCategory->id,
        ]);

        Product::query()->create([
            'name' => 'Milling Product',
            'slug' => 'milling-product',
            'sku' => 'MP-200',
            'description' => 'Milling description',
            'price' => 2000,
            'category_id' => $otherCategory->id,
        ]);

        $response = $this->get(route('catalog.index', ['category' => $targetCategory->slug]));

        $response->assertOk();
        $response->assertSee('Turning Product');
        $response->assertDontSee('Milling Product');
        $response->assertSee('Главная', false);
        $response->assertSee('Каталог', false);
        $response->assertSee('Токарные пластины', false);
    }

    public function test_home_page_builds_work_type_links_from_database(): void
    {
        $category = Category::query()->create([
            'name' => 'РўРѕРєР°СЂРЅС‹Рµ РїР»Р°СЃС‚РёРЅС‹',
            'slug' => 'tokarnye-plastiny',
            'sort_order' => 1,
        ]);

        Product::query()->create([
            'name' => 'Turning Product',
            'slug' => 'turning-product',
            'sku' => 'TP-300',
            'description' => 'Turning description',
            'price' => 3000,
            'category_id' => $category->id,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(route('catalog.index', ['category' => $category->slug]), false);
        $response->assertDontSee('Каталог.dc.html', false);
    }
}
