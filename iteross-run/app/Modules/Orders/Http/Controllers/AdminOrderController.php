<?php

namespace App\Modules\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Application\UseCases\CreateAdminOrder;
use App\Modules\Orders\Http\Requests\StoreAdminOrderRequest;
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
}
