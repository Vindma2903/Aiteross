<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\ProductPageSettingsRepository;

final class UpdateProductPageSettings
{
    public function __construct(
        private readonly ProductPageSettingsRepository $repository,
    ) {
    }

    public function handle(array $settings): void
    {
        $settings['photo_count'] = (int) ($settings['photo_count'] ?? 1);

        foreach (array_keys($settings['blocks'] ?? []) as $key) {
            $settings['blocks'][$key] = (bool) $settings['blocks'][$key];
        }

        foreach (array_keys($settings['rows'] ?? []) as $key) {
            $settings['rows'][$key] = (bool) $settings['rows'][$key];
        }

        $this->repository->save($settings);
    }
}
