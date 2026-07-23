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
        $this->repository->save($settings);
    }
}
