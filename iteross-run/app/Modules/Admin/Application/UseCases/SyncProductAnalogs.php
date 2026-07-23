<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;

class SyncProductAnalogs
{
    /**
     * @param array<int, int|string> $analogIds
     */
    public function handle(Product $product, string $analogMode, array $analogIds): void
    {
        if ($analogMode !== Product::ANALOG_MODE_MANUAL) {
            $product->manualAnalogs()->sync([]);

            return;
        }

        $normalizedIds = collect($analogIds)
            ->map(fn (mixed $value): int => (int) $value)
            ->filter(fn (int $value): bool => $value > 0 && $value !== $product->id)
            ->unique()
            ->take(10)
            ->values();

        $syncPayload = $normalizedIds
            ->mapWithKeys(fn (int $analogId, int $index): array => [
                $analogId => ['sort_order' => $index + 1],
            ])
            ->all();

        $product->manualAnalogs()->sync($syncPayload);
    }
}
