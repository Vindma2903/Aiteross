<?php

namespace App\Modules\Admin\Infrastructure\Persistence;

use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Explains why an edit made in the admin panel may not show up on the home page:
 * which file the content is read from, what is stored in it, what the page received,
 * and whether the deployed / compiled template is the current one.
 */
final class HomePageDiagnostics
{
    private const CONTENT_PATH = 'page-content/home.json';

    private const THROTTLE_KEY = 'home-page-diagnostics';

    private const THROTTLE_SECONDS = 60;

    /** A marker that only exists in a template version that renders the editable contacts. */
    private const TEMPLATE_MARKER = 'contactPhone';

    public function __construct(
        private readonly FilesystemFactory $filesystem,
    ) {
    }

    /**
     * Logs what the home page is rendered from. Throttled so a busy site does not flood the log.
     *
     * @param  array<string, mixed>  $renderedContent  the content array handed to the home view
     */
    public function logRender(array $renderedContent): void
    {
        try {
            if (! Cache::add(self::THROTTLE_KEY, true, self::THROTTLE_SECONDS)) {
                return;
            }

            Log::info('Home page diagnostics', $this->renderContext($renderedContent));
        } catch (Throwable $exception) {
            // Diagnostics must never break the page.
            Log::warning('Home page diagnostics failed.', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function contentFileContext(): array
    {
        $disk = $this->filesystem->disk('local');
        $exists = $disk->exists(self::CONTENT_PATH);
        $raw = $exists ? (string) $disk->get(self::CONTENT_PATH) : null;
        $decoded = $raw !== null ? json_decode($raw, true) : null;

        return [
            'content_file' => $this->absolutePath(self::CONTENT_PATH),
            'content_file_exists' => $exists,
            'content_file_size' => $exists ? $disk->size(self::CONTENT_PATH) : null,
            'content_file_modified_at' => $exists ? date('Y-m-d H:i:s', $disk->lastModified(self::CONTENT_PATH)) : null,
            'content_file_valid_json' => $exists ? is_array($decoded) : null,
            'content_file_has_contacts' => is_array($decoded) && array_key_exists('contacts', $decoded),
            'stored_contacts' => is_array($decoded) ? ($decoded['contacts'] ?? null) : null,
        ];
    }

    /**
     * @param  array<string, mixed>  $renderedContent
     * @return array<string, mixed>
     */
    private function renderContext(array $renderedContent): array
    {
        $viewPath = resource_path('views/home.blade.php');
        $compiledPath = app('blade.compiler')->getCompiledPath($viewPath);
        $compiledExists = is_file($compiledPath);

        return $this->contentFileContext() + [
            'rendered_contacts' => $renderedContent['contacts'] ?? null,
            'view_file' => $viewPath,
            'view_modified_at' => is_file($viewPath) ? date('Y-m-d H:i:s', filemtime($viewPath)) : null,
            'view_has_contacts_block' => is_file($viewPath)
                && str_contains((string) file_get_contents($viewPath), self::TEMPLATE_MARKER),
            'compiled_view_exists' => $compiledExists,
            'compiled_view_modified_at' => $compiledExists ? date('Y-m-d H:i:s', filemtime($compiledPath)) : null,
            'compiled_view_has_contacts_block' => $compiledExists
                ? str_contains((string) file_get_contents($compiledPath), self::TEMPLATE_MARKER)
                : null,
            'deployed_commit' => $this->deployedCommit(),
            'app_env' => config('app.env'),
            'cache_store' => config('cache.default'),
        ];
    }

    private function absolutePath(string $path): string
    {
        $disk = $this->filesystem->disk('local');

        return method_exists($disk, 'path') ? $disk->path($path) : $path;
    }

    private function deployedCommit(): ?string
    {
        $head = base_path('../.git/HEAD');

        if (! is_file($head)) {
            $head = base_path('.git/HEAD');
        }

        if (! is_file($head)) {
            return null;
        }

        $content = trim((string) file_get_contents($head));

        if (! str_starts_with($content, 'ref: ')) {
            return substr($content, 0, 10);
        }

        $ref = dirname($head).'/'.substr($content, 5);

        return is_file($ref) ? substr(trim((string) file_get_contents($ref)), 0, 10) : null;
    }
}
