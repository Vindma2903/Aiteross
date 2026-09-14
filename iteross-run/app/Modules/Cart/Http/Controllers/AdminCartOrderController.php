<?php

namespace App\Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Infrastructure\Persistence\Eloquent\CartOrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminCartOrderController extends Controller
{
    public function index(): View
    {
        $cartOrderRequests = CartOrderRequest::query()
            ->latest()
            ->get();

        return view('admin.cart-orders', [
            'cartOrderRequests' => $cartOrderRequests,
        ]);
    }

    public function toggleStatus(CartOrderRequest $cartOrderRequest): RedirectResponse
    {
        $cartOrderRequest->update([
            'status' => $cartOrderRequest->isProcessed()
                ? CartOrderRequest::STATUS_NEW
                : CartOrderRequest::STATUS_PROCESSED,
        ]);

        return redirect()
            ->route('admin.cart-orders')
            ->with('status', $cartOrderRequest->isProcessed()
                ? 'Заявка отмечена как обработанная.'
                : 'Заявка возвращена в новые.');
    }
}
