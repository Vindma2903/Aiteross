<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Domain\MailServerSettingsRepository;

final class GetMailServerSettings
{
    public function __construct(
        private readonly MailServerSettingsRepository $repository,
    ) {
    }

    public function handle(): array
    {
        return $this->repository->get();
    }
}
