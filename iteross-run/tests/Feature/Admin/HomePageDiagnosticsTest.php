<?php

namespace Tests\Feature\Admin;

use App\Modules\Admin\Domain\HomePageContent;
use App\Modules\Admin\Infrastructure\Persistence\HomePageDiagnostics;
use App\Modules\Admin\Infrastructure\Persistence\StorageHomePageContentRepository;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class HomePageDiagnosticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_saving_logs_what_was_written_and_that_it_was_verified(): void
    {
        Storage::fake('local');
        Log::spy();

        $content = HomePageContent::defaults();
        $content['contacts']['phone'] = '+7 (812) 000-11-22';

        app(StorageHomePageContentRepository::class)->save($content);

        Log::shouldHaveReceived('info')
            ->once()
            ->withArgs(fn (string $message, array $context): bool => $message === 'Home page content saved from admin.'
                && $context['write_succeeded'] === true
                && $context['verified_after_write'] === true
                && $context['saved_contacts']['phone'] === '+7 (812) 000-11-22'
                && $context['stored_contacts']['phone'] === '+7 (812) 000-11-22'
                && str_ends_with(str_replace('\\', '/', $context['content_file']), 'page-content/home.json'));
    }

    public function test_a_failed_write_is_logged_and_is_not_reported_as_saved(): void
    {
        $disk = Mockery::mock(Filesystem::class);
        $disk->shouldReceive('put')->once()->andReturn(false);
        $disk->shouldReceive('exists')->andReturn(false);
        $disk->shouldReceive('path')->andReturn('/srv/app/storage/app/private/page-content/home.json');

        $factory = Mockery::mock(FilesystemFactory::class);
        $factory->shouldReceive('disk')->with('local')->andReturn($disk);

        Log::spy();

        $repository = new StorageHomePageContentRepository($factory, new HomePageDiagnostics($factory));

        try {
            $repository->save(HomePageContent::defaults());
            $this->fail('A failed write must not look like a successful save.');
        } catch (RuntimeException $exception) {
            $this->assertStringContainsString('Could not write home page content', $exception->getMessage());
        }

        Log::shouldHaveReceived('error')
            ->once()
            ->withArgs(fn (string $message, array $context): bool => $message === 'Home page content was NOT saved correctly.'
                && $context['write_succeeded'] === false);
    }

    public function test_a_broken_content_file_is_logged_instead_of_silently_showing_defaults(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('page-content/home.json', '{ this is not json');
        Log::spy();

        $content = app(StorageHomePageContentRepository::class)->get();

        $this->assertSame(HomePageContent::defaults(), $content);

        Log::shouldHaveReceived('warning')
            ->once()
            ->withArgs(fn (string $message, array $context): bool => str_contains($message, 'not valid JSON')
                && $context['content_file_valid_json'] === false
                && $context['content_file_exists'] === true);
    }

    public function test_home_page_render_logs_stored_vs_rendered_contacts_and_template_state(): void
    {
        Storage::fake('local');
        Cache::flush();

        $content = HomePageContent::defaults();
        $content['contacts']['address'] = 'г. Казань, ул. Тестовая, 1';
        app(StorageHomePageContentRepository::class)->save($content);

        Log::spy();

        $this->get('/')->assertOk();
        $this->get('/')->assertOk();

        // Throttled: two page views, one diagnostics record.
        Log::shouldHaveReceived('info')
            ->once()
            ->withArgs(fn (string $message, array $context): bool => $message === 'Home page diagnostics'
                && $context['content_file_exists'] === true
                && $context['content_file_valid_json'] === true
                && $context['stored_contacts']['address'] === 'г. Казань, ул. Тестовая, 1'
                && $context['rendered_contacts']['address'] === 'г. Казань, ул. Тестовая, 1'
                && $context['view_has_contacts_block'] === true
                && array_key_exists('compiled_view_has_contacts_block', $context)
                && array_key_exists('deployed_commit', $context));
    }
}
