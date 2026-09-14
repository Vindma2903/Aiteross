<?php

namespace App\Modules\Cart\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CartOrderRequest extends Model
{
    public const STATUS_NEW = 'new';
    public const STATUS_PROCESSED = 'processed';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'comment',
        'items',
        'total_quantity',
        'total_price',
        'has_unknown_price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'total_quantity' => 'integer',
            'total_price' => 'integer',
            'has_unknown_price' => 'boolean',
        ];
    }

    public function isProcessed(): bool
    {
        return $this->status === self::STATUS_PROCESSED;
    }

    public function statusLabel(): string
    {
        return $this->isProcessed() ? 'Обработана' : 'Новая';
    }
}
