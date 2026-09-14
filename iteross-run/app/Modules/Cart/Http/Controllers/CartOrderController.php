<?php

namespace App\Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Application\DataTransfer\CartOrderData;
use App\Modules\Cart\Application\UseCases\SubmitCartOrder;
use App\Modules\Cart\Http\Requests\SubmitCartOrderRequest;
use Illuminate\Http\RedirectResponse;

class CartOrderController extends Controller
{
    public function store(
        SubmitCartOrderRequest $request,
        SubmitCartOrder $submitCartOrder,
    ): RedirectResponse {
        $submitCartOrder->handle(new CartOrderData(
            name: $request->string('name')->toString(),
            phone: $request->string('phone')->toString(),
            email: $request->filled('email') ? $request->string('email')->toString() : null,
            comment: $request->filled('comment') ? $request->string('comment')->toString() : null,
            items: $request->validated('items'),
        ));

        return redirect()
            ->route('cart.index')
            ->with('status', 'Заявка отправлена. Менеджер свяжется с вами для подтверждения и счёта.')
            ->with('cart_submitted', true);
    }
}
