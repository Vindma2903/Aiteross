<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\MailServerSettingsRepository;

final class UpdateMailServerSettings
{
    public function __construct(
        private readonly MailServerSettingsRepository $repository,
    ) {
    }

    public function handle(array $data): void
    {
        $current = $this->repository->get();

        if (blank($data['password'] ?? null)) {
            $data['password'] = $current['password'];
        }

        $this->repository->save($data);
    }
}
