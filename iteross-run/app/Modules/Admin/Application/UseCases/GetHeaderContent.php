<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\HeaderContentRepository;

final class GetHeaderContent
{
    public function __construct(
        private readonly HeaderContentRepository $repository,
    ) {
    }

    public function handle(): array
    {
        return $this->repository->get();
    }
}
