<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\DeliveryPageContentRepository;

final class GetDeliveryPageContent
{
    public function __construct(
        private readonly DeliveryPageContentRepository $repository,
    ) {
    }

    public function handle(): array
    {
        return $this->repository->get();
    }
}
