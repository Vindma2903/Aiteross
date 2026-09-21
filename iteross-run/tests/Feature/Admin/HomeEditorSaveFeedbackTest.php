<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeEditorSaveFeedbackTest extends TestCase
{
    use HomeEditorFixtures;
    use RefreshDatabase;

    public function test_a_blank_category_description_does_not_block_saving_the_page(): void
    {
        Storage::fake('local');

        $payload = $this->homePayload(['phone' => '+7 (812) 555-01-02']);
        $payload['work_types']['items'][0]['description'] = '';

        $this->actingAs($this->admin())
            ->post(route('admin.pages.update', ['page' => 'home']), $payload)
            ->assertSessionHasNoErrors()
            ->assertSessionHas('status', 'Изменения главной страницы сохранены.');

        Storage::disk('local')->assertExists('page-content/home.json');
    }

    public function test_a_rejected_form_tells_the_admin_what_to_fix_and_is_logged(): void
    {
        Storage::fake('local');
        Log::spy();

        $payload = $this->homePayload(['phone' => '+7 (812) 555-01-02']);
        $payload['hero']['title'] = '';

        $this->actingAs($this->admin())
            ->followingRedirects()
            ->from(route('admin.pages.editor', ['page' => 'home']))
            ->post(route('admin.pages.update', ['page' => 'home']), $payload)
            ->assertOk()
            ->assertSee('Изменения не сохранены')
            ->assertSee('Первый экран: заголовок');

        Storage::disk('local')->assertMissing('page-content/home.json');

        Log::shouldHaveReceived('warning')
            ->once()
            ->withArgs(fn (string $message, array $context): bool => str_contains($message, 'rejected by validation')
                && $context['page'] === 'home'
                && array_key_exists('hero.title', $context['errors']));
    }
}
