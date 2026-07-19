<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'stock_quantity',
        'is_visible',
        'image',
        'category_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'stock_quantity' => 'integer',
            'is_visible' => 'boolean',
        ];
    }

    public function favoriteItems(): HasMany
    {
        return $this->hasMany(FavoriteItem::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
