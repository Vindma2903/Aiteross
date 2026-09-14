<?php

namespace App\Modules\Cart\Application\UseCases;

use App\Modules\Cart\Application\DataTransfer\CartOrderData;
use App\Modules\Cart\Infrastructure\Mail\CartOrderSubmittedMail;
use Illuminate\Support\Facades\Mail;

final class SubmitCartOrder
{
    public function handle(CartOrderData $data): void
    {
        Mail::to((string) config('services.lead_requests.recipient'))
            ->send(new CartOrderSubmittedMail($data));
    }
}
