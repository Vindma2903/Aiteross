<?php

namespace App\Modules\Catalog\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CatalogFilterOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'slug',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(CatalogFilterGroup::class, 'group_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'catalog_filter_option_product')
            ->withTimestamps();
    }
}
