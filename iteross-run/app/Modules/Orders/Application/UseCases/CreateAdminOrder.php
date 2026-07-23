<?php

namespace App\Modules\Orders\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Orders\Infrastructure\Persistence\Eloquent\Order;
use Illuminate\Support\Facades\DB;

final class CreateAdminOrder
{
    public function handle(array $data): Order
    {
        return DB::transaction(function () use ($data): Order {
            $product = Product::query()->findOrFail($data['product_id']);

            $order = Order::query()->create([
                'user_id' => $data['user_id'],
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_description' => $product->description,
                'product_image' => $product->image,
                'product_price' => $product->price,
                'product_unit_mode' => $product->unit_mode,
                'product_unit_multiplier' => $product->unit_multiplier,
                'quantity' => $data['quantity'],
                'status' => $data['status'],
            ]);

            $order->update([
                'order_number' => 'ORD-'.str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
            ]);

            return $order->fresh(['user', 'product']);
        });
    }
}
