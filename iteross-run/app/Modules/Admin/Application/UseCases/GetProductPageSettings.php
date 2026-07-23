<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\ProductPageSettingsRepository;

final class GetProductPageSettings
{
    public function __construct(
        private readonly ProductPageSettingsRepository $repository,
    ) {
    }

    public function handle(): array
    {
        return $this->repository->get();
    }
}
