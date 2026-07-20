<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\HomePageContentRepository;

final class GetHomePageContent
{
    public function __construct(
        private readonly HomePageContentRepository $repository,
    ) {
    }

    public function handle(): array
    {
        return $this->repository->get();
    }
}
