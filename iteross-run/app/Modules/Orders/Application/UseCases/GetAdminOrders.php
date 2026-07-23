<?php

namespace App\Modules\Orders\Application\UseCases;

use App\Modules\Orders\Infrastructure\Persistence\Eloquent\Order;
use Illuminate\Support\Collection;

final class GetAdminOrders
{
    public function handle(): Collection
    {
        return Order::query()
            ->with(['user', 'product'])
            ->orderByDesc('id')
            ->get();
    }
}
