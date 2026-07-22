<?php

namespace App\Modules\Catalog\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Modules\Favorites\Infrastructure\Persistence\Eloquent\FavoriteItem;

class Product extends Model
{
    use HasFactory;

    public const UNIT_MODE_PIECES = 'pieces';
    public const UNIT_MODE_PACKS = 'packs';

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'stock_quantity',
        'unit_mode',
        'unit_multiplier',
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
        return $this->unit_mode === self::UNIT_MODE_PACKS ? 'упаковки' : 'штуки';
    }

    public function unitShortLabel(): string
    {
        return $this->unit_mode === self::UNIT_MODE_PACKS ? 'упак.' : 'шт.';
    }

    public function stockLabel(): string
    {
        if ($this->unit_mode === self::UNIT_MODE_PACKS) {
            return $this->stock_quantity.' '.$this->pluralize($this->stock_quantity, 'упаковка', 'упаковки', 'упаковок');
        }

        return $this->stock_quantity.' шт.';
    }

    public function unitDetailsLabel(): ?string
    {
        if ($this->unit_mode !== self::UNIT_MODE_PACKS || $this->unit_multiplier <= 1) {
            return null;
        }

        return '1 упаковка = '.$this->unit_multiplier.' шт.';
    }

    private function pluralize(int $value, string $one, string $few, string $many): string
    {
        $mod100 = $value % 100;
        $mod10 = $value % 10;

        if ($mod100 >= 11 && $mod100 <= 14) {
            return $many;
        }

        return match (true) {
            $mod10 === 1 => $one,
            $mod10 >= 2 && $mod10 <= 4 => $few,
            default => $many,
        };
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
}
