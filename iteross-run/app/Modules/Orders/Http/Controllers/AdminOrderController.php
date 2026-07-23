<?php

namespace App\Modules\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Application\UseCases\CreateAdminOrder;
use App\Modules\Orders\Application\UseCases\UpdateAdminOrder;
use App\Modules\Orders\Http\Requests\StoreAdminOrderRequest;
use App\Modules\Orders\Http\Requests\UpdateAdminOrderRequest;
use App\Modules\Orders\Infrastructure\Persistence\Eloquent\Order;
use Illuminate\Http\RedirectResponse;

class AdminOrderController extends Controller
{
    public function store(
        StoreAdminOrderRequest $request,
        CreateAdminOrder $createAdminOrder,
    ): RedirectResponse {
        $createAdminOrder->handle($request->validated());

        return redirect()
            ->route('admin.dashboard', ['section' => 'orders'])
            ->with('status', 'Заявка создана.');
    }

    public function update(
        UpdateAdminOrderRequest $request,
        Order $order,
        UpdateAdminOrder $updateAdminOrder,
    ): RedirectResponse {
        $updateAdminOrder->handle($order, $request->validated());

        return redirect()
            ->route('admin.dashboard', ['section' => 'orders'])
            ->with('status', 'Заявка обновлена.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()
            ->route('admin.dashboard', ['section' => 'orders'])
            ->with('status', 'Заявка удалена.');
    }
}
