<?php

namespace Tests\Feature\Cart;

use App\Modules\Cart\Infrastructure\Persistence\Eloquent\CartOrderRequest;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCartOrdersTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::query()->create([
            'name' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+7 (999) 000-00-00',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_admin_can_see_cart_order_requests_list(): void
    {
        $admin = $this->makeAdmin();

        $cartOrderRequest = CartOrderRequest::query()->create([
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'email' => 'ivan@example.com',
            'comment' => null,
            'items' => [
                ['product_id' => 1, 'sku' => 'CNMG120408-GM', 'name' => 'Пластина CNMG120408-GM', 'material' => 'Сталь', 'price' => 1190, 'qty' => 20, 'url' => '/products/cnmg120408-gm'],
            ],
            'total_quantity' => 20,
            'total_price' => 23800,
            'has_unknown_price' => false,
            'status' => CartOrderRequest::STATUS_NEW,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.cart-orders'));

        $response->assertOk();
        $response->assertSee('Заявки из корзины');
        $response->assertSee('Иван Иванов');
        $response->assertSee('Пластина CNMG120408-GM');
        $response->assertSee('Новая');
        $response->assertSee(route('admin.cart-orders.toggle-status', $cartOrderRequest), false);
    }

    public function test_admin_can_toggle_cart_order_request_status(): void
    {
        $admin = $this->makeAdmin();

        $cartOrderRequest = CartOrderRequest::query()->create([
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'email' => null,
            'comment' => null,
            'items' => [['sku' => 'TEST', 'name' => 'Товар', 'price' => null, 'qty' => 10]],
            'total_quantity' => 10,
            'total_price' => 0,
            'has_unknown_price' => true,
            'status' => CartOrderRequest::STATUS_NEW,
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('admin.cart-orders.toggle-status', $cartOrderRequest));

        $response
            ->assertRedirect(route('admin.cart-orders'))
            ->assertSessionHas('status', 'Заявка отмечена как обработанная.');

        $this->assertSame(CartOrderRequest::STATUS_PROCESSED, $cartOrderRequest->fresh()->status);

        $response = $this->actingAs($admin)
            ->patch(route('admin.cart-orders.toggle-status', $cartOrderRequest));

        $response->assertSessionHas('status', 'Заявка возвращена в новые.');
        $this->assertSame(CartOrderRequest::STATUS_NEW, $cartOrderRequest->fresh()->status);
    }

    public function test_regular_user_cannot_view_cart_order_requests(): void
    {
        $user = User::query()->create([
            'name' => 'User',
            'first_name' => 'Regular',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+7 (999) 111-11-11',
            'role' => User::ROLE_USER,
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.cart-orders'));

        $response->assertRedirect(route('account'));
    }
}
