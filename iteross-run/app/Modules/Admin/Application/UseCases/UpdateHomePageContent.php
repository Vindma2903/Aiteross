<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\HomePageContentRepository;

final class UpdateHomePageContent
{
    public function __construct(
        private readonly HomePageContentRepository $repository,
    ) {
    }

    public function handle(array $content): void
    {
        $this->repository->save($content);
    }
}
