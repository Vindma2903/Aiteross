<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\HeaderContentRepository;

final class UpdateHeaderContent
{
    public function __construct(
        private readonly HeaderContentRepository $repository,
    ) {
    }

    public function handle(array $data): void
    {
        $data['header_nav'] = array_values($data['header_nav'] ?? []);
        $this->repository->save($data);
    }
}
