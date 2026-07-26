<?php

namespace App\Modules\Catalog\Infrastructure\Persistence\Eloquent;

use App\Modules\Favorites\Infrastructure\Persistence\Eloquent\FavoriteItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public const UNIT_MODE_PIECES = 'pieces';
    public const UNIT_MODE_PACKS = 'packs';
    public const ANALOG_MODE_AUTOMATIC = 'automatic';
    public const ANALOG_MODE_MANUAL = 'manual';

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'stock_quantity',
        'unit_mode',
        'unit_multiplier',
        'analog_mode',
        'is_visible',
        'image',
        'category_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'stock_quantity' => 'integer',
            'unit_multiplier' => 'integer',
            'is_visible' => 'boolean',
        ];
    }

    public function unitLabel(): string
    {
        return 'шт.';
    }

    public function unitShortLabel(): string
    {
        return 'шт.';
    }

    public function stockLabel(): string
    {
        return $this->stock_quantity.' шт.';
    }

    public function unitDetailsLabel(): ?string
    {
        if ($this->unit_multiplier <= 1) {
            return null;
        }

        return 'Упаковка: '.$this->unit_multiplier.' шт.';
    }

    public function favoriteItems(): HasMany
    {
        return $this->hasMany(FavoriteItem::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function filterOptions(): BelongsToMany
    {
        return $this->belongsToMany(CatalogFilterOption::class, 'catalog_filter_option_product')
            ->with('group')
            ->withTimestamps();
    }

    public function manualAnalogs(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'product_analogs', 'product_id', 'analog_product_id')
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderBy('product_analogs.sort_order')
            ->orderBy('product_analogs.id');
    }
}
