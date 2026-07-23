<?php

namespace Tests\Feature\Admin;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use App\Modules\Orders\Infrastructure\Persistence\Eloquent\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OrderCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_order_from_orders_modal(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000101',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-orders@example.com',
            'password' => Hash::make('password'),
        ]);

        $customer = User::query()->create([
            'name' => 'Иван Петров',
            'first_name' => 'Иван',
            'last_name' => 'Петров',
            'company' => 'ООО «Техмаш»',
            'phone' => '+79000000102',
            'role' => User::ROLE_USER,
            'email' => 'customer-orders@example.com',
            'password' => Hash::make('password'),
        ]);

        $product = Product::query()->create([
            'name' => 'Тестовая пластина',
            'slug' => 'testovaya-plastina-art-100',
            'sku' => 'ART-100',
            'description' => 'Описание тестовой пластины',
            'price' => 2500,
            'stock_quantity' => 25,
            'unit_mode' => Product::UNIT_MODE_PACKS,
            'unit_multiplier' => 10,
            'is_visible' => true,
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.orders.store'), [
                'user_id' => $customer->id,
                'product_id' => $product->id,
                'quantity' => 2,
                'status' => Order::STATUS_SHIPPING,
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'orders']))
            ->assertSessionHas('status', 'Заявка создана.');

        $order = Order::query()->first();

        $this->assertNotNull($order);
        $this->assertSame($customer->id, $order->user_id);
        $this->assertSame($product->id, $order->product_id);
        $this->assertSame('Тестовая пластина', $order->product_name);
        $this->assertSame('Описание тестовой пластины', $order->product_description);
        $this->assertSame(2500, $order->product_price);
        $this->assertSame(Product::UNIT_MODE_PACKS, $order->product_unit_mode);
        $this->assertSame(10, $order->product_unit_multiplier);
        $this->assertSame(2, $order->quantity);
        $this->assertSame(Order::STATUS_SHIPPING, $order->status);
        $this->assertStringStartsWith('ORD-', (string) $order->order_number);

        $dashboardResponse = $this
            ->actingAs($admin)
            ->get(route('admin.dashboard', ['section' => 'orders']));

        $dashboardResponse->assertOk();
        $dashboardResponse->assertSee($order->order_number);
        $dashboardResponse->assertSee('Тестовая пластина');
        $dashboardResponse->assertSee('В доставке');
    }

    public function test_regular_user_cannot_create_order_from_admin(): void
    {
        $user = User::query()->create([
            'name' => 'Regular User',
            'first_name' => 'Regular',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000103',
            'role' => User::ROLE_USER,
            'email' => 'regular-orders@example.com',
            'password' => Hash::make('password'),
        ]);

        $customer = User::query()->create([
            'name' => 'Анна Козлова',
            'first_name' => 'Анна',
            'last_name' => 'Козлова',
            'company' => 'АО «Промдеталь»',
            'phone' => '+79000000104',
            'role' => User::ROLE_USER,
            'email' => 'another-customer-orders@example.com',
            'password' => Hash::make('password'),
        ]);

        $product = Product::query()->create([
            'name' => 'Тестовый товар',
            'slug' => 'testovyy-tovar-art-101',
            'sku' => 'ART-101',
            'description' => 'Описание',
            'price' => 1800,
            'stock_quantity' => 8,
            'is_visible' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.orders.store'), [
                'user_id' => $customer->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'status' => Order::STATUS_FORMING,
            ]);

        $response->assertRedirect(route('account'));
        $this->assertSame(0, Order::query()->count());
    }
}
