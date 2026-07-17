<?php

namespace Tests\Feature\Favorites;

use App\Models\FavoriteItem;
use App\Models\Product;
use App\Models\User;
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
}
