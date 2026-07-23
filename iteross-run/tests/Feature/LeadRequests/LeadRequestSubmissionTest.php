<?php

namespace Tests\Feature\LeadRequests;

use App\Modules\LeadRequests\Infrastructure\Mail\LeadRequestSubmittedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LeadRequestSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_lead_request_with_attachment(): void
    {
        Mail::fake();
        Storage::fake('local');

        $response = $this->post(route('lead-requests.store'), [
            'company_name' => 'Иван Иванов, ООО «Компания»',
            'phone' => '+7 (999) 123-45-67',
            'email' => 'sales@example.com',
            'task_description' => 'Нужны пластины для тестовой партии.',
            'attachment' => UploadedFile::fake()->create('brief.pdf', 256, 'application/pdf'),
        ]);

        $response
            ->assertRedirect('/#lead-form-section')
            ->assertSessionHas('status', 'Заявка отправлена. Мы свяжемся с вами в течение рабочего дня.');

        $storedFiles = Storage::disk('local')->files('lead-requests');
        $this->assertCount(1, $storedFiles);

        Mail::assertSent(
            LeadRequestSubmittedMail::class,
            function ($mail) use ($storedFiles): bool {
                return $mail->hasTo((string) config('services.lead_requests.recipient'))
                    && $mail->data->companyName === 'Иван Иванов, ООО «Компания»'
                    && $mail->storedAttachment !== null
                    && $mail->storedAttachment['path'] === $storedFiles[0];
            }
        );
    }

    public function test_invalid_lead_request_is_rejected_and_not_sent(): void
    {
        Mail::fake();
        Storage::fake('local');

        $response = $this->from('/#lead-form-section')->post(route('lead-requests.store'), [
            'company_name' => '',
            'phone' => '',
            'email' => 'bad-email',
            'task_description' => '',
        ]);

        $response
            ->assertRedirect('/#lead-form-section')
            ->assertSessionHasErrors([
                'company_name',
                'phone',
                'email',
                'task_description',
            ]);

        Storage::disk('local')->assertMissing('lead-requests');
        Mail::assertNothingSent();
    }
}
