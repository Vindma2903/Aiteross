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

    public function test_admin_can_update_order_from_orders_modal(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000105',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-orders-update@example.com',
            'password' => Hash::make('password'),
        ]);

        $customer = User::query()->create([
            'name' => 'Test Customer',
            'first_name' => 'Test',
            'last_name' => 'Customer',
            'company' => 'Old Company',
            'phone' => '+79000000106',
            'role' => User::ROLE_USER,
            'email' => 'customer-update@example.com',
            'password' => Hash::make('password'),
        ]);

        $newCustomer = User::query()->create([
            'name' => 'New Customer',
            'first_name' => 'New',
            'last_name' => 'Customer',
            'company' => 'New Company',
            'phone' => '+79000000107',
            'role' => User::ROLE_USER,
            'email' => 'customer-update-new@example.com',
            'password' => Hash::make('password'),
        ]);

        $product = Product::query()->create([
            'name' => 'Old Product',
            'slug' => 'old-product-art-102',
            'sku' => 'ART-102',
            'description' => 'Old Description',
            'price' => 1500,
            'stock_quantity' => 12,
            'unit_mode' => Product::UNIT_MODE_PIECES,
            'unit_multiplier' => 1,
            'is_visible' => true,
        ]);

        $newProduct = Product::query()->create([
            'name' => 'New Product',
            'slug' => 'new-product-art-103',
            'sku' => 'ART-103',
            'description' => 'New Description',
            'price' => 3200,
            'stock_quantity' => 7,
            'unit_mode' => Product::UNIT_MODE_PACKS,
            'unit_multiplier' => 5,
            'is_visible' => true,
        ]);

        $order = Order::query()->create([
            'order_number' => 'ORD-000111',
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_description' => $product->description,
            'product_image' => $product->image,
            'product_price' => $product->price,
            'product_unit_mode' => $product->unit_mode,
            'product_unit_multiplier' => $product->unit_multiplier,
            'quantity' => 1,
            'status' => Order::STATUS_FORMING,
        ]);

        $response = $this
            ->actingAs($admin)
            ->put(route('admin.orders.update', $order), [
                'order_id' => $order->order_number,
                'user_id' => $newCustomer->id,
                'product_id' => $newProduct->id,
                'quantity' => 4,
                'status' => Order::STATUS_DELIVERED,
            ]);

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'orders']))
            ->assertSessionHas('status', 'Заявка обновлена.');

        $order->refresh();

        $this->assertSame($newCustomer->id, $order->user_id);
        $this->assertSame($newProduct->id, $order->product_id);
        $this->assertSame('New Product', $order->product_name);
        $this->assertSame('New Description', $order->product_description);
        $this->assertSame(3200, $order->product_price);
        $this->assertSame(Product::UNIT_MODE_PACKS, $order->product_unit_mode);
        $this->assertSame(5, $order->product_unit_multiplier);
        $this->assertSame(4, $order->quantity);
        $this->assertSame(Order::STATUS_DELIVERED, $order->status);
        $this->assertSame('ORD-000111', $order->order_number);

        $accountResponse = $this
            ->actingAs($newCustomer)
            ->get(route('account'));

        $accountResponse->assertOk();
        $accountResponse->assertSee('ORD-000111');
        $accountResponse->assertSee('New Product');
        $accountResponse->assertSee('Доставлено');
     }

    public function test_admin_can_delete_order_and_it_disappears_from_user_account(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+79000000108',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin-orders-delete@example.com',
            'password' => Hash::make('password'),
        ]);

        $customer = User::query()->create([
            'name' => 'Delete Customer',
            'first_name' => 'Delete',
            'last_name' => 'Customer',
            'company' => 'Delete Company',
            'phone' => '+79000000109',
            'role' => User::ROLE_USER,
            'email' => 'customer-delete@example.com',
            'password' => Hash::make('password'),
        ]);

        $product = Product::query()->create([
            'name' => 'Delete Product',
            'slug' => 'delete-product-art-104',
            'sku' => 'ART-104',
            'description' => 'Delete Description',
            'price' => 1900,
            'stock_quantity' => 5,
            'unit_mode' => Product::UNIT_MODE_PIECES,
            'unit_multiplier' => 1,
            'is_visible' => true,
        ]);

        $order = Order::query()->create([
            'order_number' => 'ORD-000222',
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_description' => $product->description,
            'product_image' => $product->image,
            'product_price' => $product->price,
            'product_unit_mode' => $product->unit_mode,
            'product_unit_multiplier' => $product->unit_multiplier,
            'quantity' => 2,
            'status' => Order::STATUS_FORMING,
        ]);

        $beforeDeleteAccount = $this
            ->actingAs($customer)
            ->get(route('account'));

        $beforeDeleteAccount->assertOk();
        $beforeDeleteAccount->assertSee('ORD-000222');
        $beforeDeleteAccount->assertSee('Delete Product');

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.orders.destroy', $order));

        $response
            ->assertRedirect(route('admin.dashboard', ['section' => 'orders']))
            ->assertSessionHas('status', 'Заявка удалена.');

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
            'order_number' => 'ORD-000222',
        ]);

        $afterDeleteAccount = $this
            ->actingAs($customer)
            ->get(route('account'));

        $afterDeleteAccount->assertOk();
        $afterDeleteAccount->assertDontSee('ORD-000222');
        $afterDeleteAccount->assertDontSee('Delete Product');
    }
}
