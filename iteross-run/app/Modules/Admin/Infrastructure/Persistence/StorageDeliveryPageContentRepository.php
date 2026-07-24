<?php

namespace App\Modules\Admin\Infrastructure\Persistence;

use App\Modules\Admin\Domain\DeliveryPageContent;
use App\Modules\Admin\Domain\DeliveryPageContentRepository;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;

final class StorageDeliveryPageContentRepository implements DeliveryPageContentRepository
{
    private const PATH = 'page-content/delivery.json';

    public function __construct(
        private readonly FilesystemFactory $filesystem,
    ) {
    }

    public function get(): array
    {
        $disk = $this->filesystem->disk('local');

        if (! $disk->exists(self::PATH)) {
            return DeliveryPageContent::defaults();
        }

        $decoded = json_decode($disk->get(self::PATH), true);

        if (! is_array($decoded)) {
            return DeliveryPageContent::defaults();
        }

        return $this->mergeRecursive(DeliveryPageContent::defaults(), $decoded);
    }

    public function save(array $content): void
    {
        $this->filesystem->disk('local')->put(
            self::PATH,
            json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        );
    }

    private function mergeRecursive(array $defaults, array $stored): array
    {
        foreach ($stored as $key => $value) {
            if (is_array($value) && isset($defaults[$key]) && is_array($defaults[$key]) && $this->isAssociative($value)) {
                $defaults[$key] = $this->mergeRecursive($defaults[$key], $value);
                continue;
            }

            $defaults[$key] = $value;
        }

        return $defaults;
    }

    private function isAssociative(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
