<?php

namespace App\Modules\Admin\Infrastructure\Persistence;

use App\Modules\Admin\Domain\MailServerSettings;
use App\Modules\Admin\Domain\MailServerSettingsRepository;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Support\Facades\Crypt;

final class StorageMailServerSettingsRepository implements MailServerSettingsRepository
{
    private const PATH = 'settings/mail-server.json';

    public function __construct(
        private readonly FilesystemFactory $filesystem,
    ) {
    }

    public function get(): array
    {
        $disk = $this->filesystem->disk('local');

        if (! $disk->exists(self::PATH)) {
            return MailServerSettings::defaults();
        }

        $decoded = json_decode($disk->get(self::PATH), true);

        if (! is_array($decoded)) {
            return MailServerSettings::defaults();
        }

        $settings = array_replace(MailServerSettings::defaults(), $decoded);

        if (filled($settings['password'])) {
            try {
                $settings['password'] = Crypt::decryptString($settings['password']);
            } catch (\Throwable) {
                $settings['password'] = '';
            }
        }

        return $settings;
    }

    public function save(array $settings): void
    {
        if (filled($settings['password'] ?? null)) {
            $settings['password'] = Crypt::encryptString($settings['password']);
        }

        $this->filesystem->disk('local')->put(
            self::PATH,
            json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        );
    }
}
