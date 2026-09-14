<?php

namespace App\Modules\Cart\Application\DataTransfer;

final readonly class CartOrderData
{
    /**
     * @param  array<int, array{product_id: ?int, sku: string, name: ?string, material: ?string, price: ?float, qty: int, url: ?string}>  $items
     */
    public function __construct(
        public string $name,
        public string $phone,
        public ?string $email,
        public ?string $comment,
        public array $items,
    ) {}

    public function totalQuantity(): int
    {
        return array_sum(array_column($this->items, 'qty'));
    }

    public function totalPrice(): float
    {
        return array_sum(array_map(
            fn (array $item) => ($item['price'] ?? 0) * $item['qty'],
            $this->items,
        ));
    }

    public function hasUnknownPrice(): bool
    {
        foreach ($this->items as $item) {
            if (empty($item['price'])) {
                return true;
            }
        }

        return false;
    }
}
