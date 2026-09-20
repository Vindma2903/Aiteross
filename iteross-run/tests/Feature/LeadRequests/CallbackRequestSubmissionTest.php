<?php

namespace Tests\Feature\LeadRequests;

use App\Modules\LeadRequests\Infrastructure\Mail\CallbackRequestSubmittedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CallbackRequestSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_callback_request_with_several_attachments(): void
    {
        Mail::fake();
        Storage::fake('local');

        $response = $this->post(route('callback-requests.store'), [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'description' => 'Перезвоните по вопросу поставки.',
            'attachments' => [
                UploadedFile::fake()->create('brief.pdf', 256, 'application/pdf'),
                UploadedFile::fake()->create('scheme.png', 128, 'image/png'),
                UploadedFile::fake()->create('spec.docx', 64, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
            ],
        ]);

        $response
            ->assertRedirect('/')
            ->assertSessionHas('callback_status', 'Заявка отправлена. Мы перезвоним вам в течение рабочего дня.')
            ->assertSessionHas('open_callback_modal', true);

        $storedFiles = Storage::disk('local')->files('lead-requests');
        $this->assertCount(3, $storedFiles);

        Mail::assertSent(
            CallbackRequestSubmittedMail::class,
            function ($mail) use ($storedFiles): bool {
                return $mail->hasTo((string) config('services.lead_requests.recipient'))
                    && $mail->data->name === 'Иван Иванов'
                    && count($mail->storedAttachments) === 3
                    && array_column($mail->storedAttachments, 'original_name') === ['brief.pdf', 'scheme.png', 'spec.docx']
                    && $this->sameValues(array_column($mail->storedAttachments, 'path'), $storedFiles)
                    && count($mail->attachments()) === 3;
            }
        );
    }

    public function test_invalid_callback_request_is_rejected_and_not_sent(): void
    {
        Mail::fake();
        Storage::fake('local');

        $response = $this->from('/')->post(route('callback-requests.store'), [
            'name' => '',
            'phone' => '',
            'description' => str_repeat('a', 5001),
        ]);

        $response
            ->assertRedirect('/')
            ->assertSessionHasErrorsIn('callbackRequest', [
                'name',
                'phone',
                'description',
            ]);

        Storage::disk('local')->assertMissing('lead-requests');
        Mail::assertNothingSent();
    }

    public function test_mail_failure_is_logged_and_shown_to_the_user_instead_of_a_500(): void
    {
        Storage::fake('local');
        Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('535 5.7.8 Authentication failed'));
        Log::spy();

        $response = $this->from('/')->post(route('callback-requests.store'), [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'description' => 'Перезвоните по вопросу поставки.',
        ]);

        $response
            ->assertRedirect('/')
            ->assertSessionHasErrors('delivery', null, 'callbackRequest')
            ->assertSessionMissing('callback_status');

        Log::shouldHaveReceived('error')
            ->once()
            ->withArgs(fn (string $message, array $context): bool => $message === 'Callback request was not delivered.'
                && $context['message'] === '535 5.7.8 Authentication failed');
    }

    public function test_callback_request_works_without_attachments(): void
    {
        Mail::fake();
        Storage::fake('local');

        $this->post(route('callback-requests.store'), [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
        ])->assertSessionHas('callback_status');

        Mail::assertSent(
            CallbackRequestSubmittedMail::class,
            fn ($mail): bool => $mail->storedAttachments === [] && $mail->attachments() === []
        );
    }

    public function test_callback_request_rejects_too_many_or_unsupported_or_oversized_attachments(): void
    {
        Mail::fake();
        Storage::fake('local');

        $base = ['name' => 'Иван Иванов', 'phone' => '+7 (999) 123-45-67'];

        $tooMany = array_map(
            fn (int $i) => UploadedFile::fake()->create("file-$i.pdf", 10, 'application/pdf'),
            range(1, 11),
        );

        $this->from('/')->post(route('callback-requests.store'), $base + ['attachments' => $tooMany])
            ->assertSessionHasErrors('attachments', errorBag: 'callbackRequest');

        $this->from('/')->post(route('callback-requests.store'), $base + ['attachments' => [
            UploadedFile::fake()->create('virus.exe', 10, 'application/x-msdownload'),
        ]])->assertSessionHasErrors('attachments.0', errorBag: 'callbackRequest');

        $this->from('/')->post(route('callback-requests.store'), $base + ['attachments' => [
            UploadedFile::fake()->create('a.pdf', 12000, 'application/pdf'),
            UploadedFile::fake()->create('b.pdf', 12000, 'application/pdf'),
        ]])->assertSessionHasErrors('attachments', errorBag: 'callbackRequest');

        Storage::disk('local')->assertMissing('lead-requests');
        Mail::assertNothingSent();
    }

    private function sameValues(array $expected, array $actual): bool
    {
        sort($expected);
        sort($actual);

        return $expected === $actual;
    }

    public function test_callback_request_returns_to_the_page_it_was_sent_from(): void
    {
        Mail::fake();

        $this->from('/catalog?search=plate')->post(route('callback-requests.store'), [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
        ])
            ->assertRedirect('/catalog?search=plate')
            ->assertSessionHas('open_callback_modal', true);
    }
}
