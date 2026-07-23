<?php

namespace Tests\Feature\LeadRequests;

use App\Modules\LeadRequests\Infrastructure\Mail\CallbackRequestSubmittedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CallbackRequestSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_callback_request_with_attachment(): void
    {
        Mail::fake();
        Storage::fake('local');

        $response = $this->post(route('callback-requests.store'), [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'description' => 'Перезвоните по вопросу поставки.',
            'attachment' => UploadedFile::fake()->create('brief.pdf', 256, 'application/pdf'),
        ]);

        $response
            ->assertRedirect('/')
            ->assertSessionHas('callback_status', 'Заявка отправлена. Мы перезвоним вам в течение рабочего дня.')
            ->assertSessionHas('open_callback_modal', true);

        $storedFiles = Storage::disk('local')->files('lead-requests');
        $this->assertCount(1, $storedFiles);

        Mail::assertSent(
            CallbackRequestSubmittedMail::class,
            function ($mail) use ($storedFiles): bool {
                return $mail->hasTo((string) config('services.lead_requests.recipient'))
                    && $mail->data->name === 'Иван Иванов'
                    && $mail->storedAttachment !== null
                    && $mail->storedAttachment['path'] === $storedFiles[0];
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
}
