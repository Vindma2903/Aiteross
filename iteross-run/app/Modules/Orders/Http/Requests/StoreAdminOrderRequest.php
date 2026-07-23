<?php

namespace App\Modules\Orders\Http\Requests;

use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use App\Modules\Orders\Infrastructure\Persistence\Eloquent\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminOrderRequest extends FormRequest
{
    protected $errorBag = 'createOrder';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', User::ROLE_USER)),
            ],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            'status' => ['required', Rule::in([
                Order::STATUS_FORMING,
                Order::STATUS_SHIPPING,
                Order::STATUS_DELIVERED,
            ])],
        ];
    }
}
