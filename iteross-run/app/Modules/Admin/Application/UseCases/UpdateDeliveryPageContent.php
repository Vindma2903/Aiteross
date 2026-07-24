<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\DeliveryPageContentRepository;

final class UpdateDeliveryPageContent
{
    public function __construct(
        private readonly DeliveryPageContentRepository $repository,
    ) {
    }

    public function handle(array $content): void
    {
        $this->repository->save($content);
    }
}
