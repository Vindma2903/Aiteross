<?php

namespace App\Modules\Orders\Infrastructure\Persistence\Eloquent;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    public const STATUS_FORMING = 'forming';
    public const STATUS_SHIPPING = 'shipping';
    public const STATUS_DELIVERED = 'delivered';

    protected $fillable = [
        'order_number',
        'user_id',
        'product_id',
        'product_name',
        'product_description',
        'product_image',
        'product_price',
        'product_unit_mode',
        'product_unit_multiplier',
        'quantity',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'product_id' => 'integer',
            'product_price' => 'integer',
            'product_unit_multiplier' => 'integer',
            'quantity' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_SHIPPING => 'В доставке',
            self::STATUS_DELIVERED => 'Доставлено',
            default => 'Формируем заказ',
        };
    }

    public function statusClass(): string
    {
        return match ($this->status) {
            self::STATUS_SHIPPING => 'progress',
            self::STATUS_DELIVERED => 'done',
            default => 'new',
        };
    }

    public function quantityLabel(): string
    {
        if ($this->product_unit_mode === Product::UNIT_MODE_PACKS) {
            return $this->quantity.' упаковок';
        }

        return $this->quantity.' шт.';
    }
}
