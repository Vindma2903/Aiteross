<?php

namespace App\Modules\Admin\Infrastructure\Persistence;

use App\Modules\Admin\Domain\HeaderContent;
use App\Modules\Admin\Domain\HeaderContentRepository;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;

final class StorageHeaderContentRepository implements HeaderContentRepository
{
    private const PATH = 'page-content/header.json';

    public function __construct(
        private readonly FilesystemFactory $filesystem,
    ) {
    }

    public function get(): array
    {
        $disk = $this->filesystem->disk('local');

        if (! $disk->exists(self::PATH)) {
            return HeaderContent::defaults();
        }

        $decoded = json_decode($disk->get(self::PATH), true);

        return is_array($decoded) ? array_replace_recursive(HeaderContent::defaults(), $decoded) : HeaderContent::defaults();
    }

    public function save(array $content): void
    {
        $this->filesystem->disk('local')->put(
            self::PATH,
            json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        );
    }
}
