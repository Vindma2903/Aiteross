<?php

namespace App\Modules\Cart\Application\UseCases;

use App\Modules\Cart\Application\DataTransfer\CartOrderData;
use App\Modules\Cart\Infrastructure\Mail\CartOrderSubmittedMail;
use App\Modules\Cart\Infrastructure\Persistence\Eloquent\CartOrderRequest;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class SubmitCartOrder
{
    public function handle(CartOrderData $data): CartOrderRequest
    {
        $request = CartOrderRequest::query()->create([
            'name' => $data->name,
            'phone' => $data->phone,
            'email' => $data->email,
            'comment' => $data->comment,
            'items' => $data->items,
            'total_quantity' => $data->totalQuantity(),
            'total_price' => $data->totalPrice(),
            'has_unknown_price' => $data->hasUnknownPrice(),
            'status' => CartOrderRequest::STATUS_NEW,
        ]);

        try {
            Mail::to((string) config('services.lead_requests.recipient'))
                ->send(new CartOrderSubmittedMail($data));
        } catch (Throwable $exception) {
            // The request is already saved and visible in the admin panel,
            // so a mail outage shouldn't fail the customer's submission.
            report($exception);
        }

        return $request;
    }
}
