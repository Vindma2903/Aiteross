<?php

namespace App\Modules\Admin\Infrastructure\Persistence;

use App\Modules\Admin\Domain\HomePageContent;
use App\Modules\Admin\Domain\HomePageContentRepository;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Support\Facades\Log;
use RuntimeException;

final class StorageHomePageContentRepository implements HomePageContentRepository
{
    private const PATH = 'page-content/home.json';

    public function __construct(
        private readonly FilesystemFactory $filesystem,
        private readonly HomePageDiagnostics $diagnostics,
    ) {
    }

    public function get(): array
    {
        $disk = $this->filesystem->disk('local');

        if (! $disk->exists(self::PATH)) {
            return HomePageContent::defaults();
        }

        $decoded = json_decode($disk->get(self::PATH), true);

        if (! is_array($decoded)) {
            // A broken file silently falls back to the defaults, so admin edits look "lost".
            Log::warning('Home page content file is not valid JSON, defaults are shown instead.', [
                'json_error' => json_last_error_msg(),
            ] + $this->diagnostics->contentFileContext());

            return HomePageContent::defaults();
        }

        return $this->mergeRecursive(HomePageContent::defaults(), $decoded);
    }

    public function save(array $content): void
    {
        $disk = $this->filesystem->disk('local');
        $json = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $written = $disk->put(self::PATH, $json);

        // Read the file back to prove that what the admin saved is really on disk.
        $stored = $written ? json_decode((string) $disk->get(self::PATH), true) : null;
        $verified = is_array($stored) && ($stored['contacts'] ?? null) === ($content['contacts'] ?? null);

        $context = [
            'write_succeeded' => (bool) $written,
            'bytes_written' => strlen((string) $json),
            'saved_contacts' => $content['contacts'] ?? null,
            'verified_after_write' => $verified,
        ] + $this->diagnostics->contentFileContext();

        if (! $written || ! $verified) {
            Log::error('Home page content was NOT saved correctly.', $context);

            throw new RuntimeException('Could not write home page content to '.($context['content_file'] ?? self::PATH));
        }

        Log::info('Home page content saved from admin.', $context);
    }

    private function mergeRecursive(array $defaults, array $stored): array
    {
        foreach ($stored as $key => $value) {
            if (is_array($value) && isset($defaults[$key]) && is_array($defaults[$key]) && $this->isAssociative($value)) {
                $defaults[$key] = $this->mergeRecursive($defaults[$key], $value);
                continue;
            }

            $defaults[$key] = $value;
        }

        return $defaults;
    }

    private function isAssociative(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
