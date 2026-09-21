<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeContactsTest extends TestCase
{
    use HomeEditorFixtures;
    use RefreshDatabase;

    public function test_home_page_shows_default_contacts_until_they_are_edited(): void
    {
        Storage::fake('local');

        $contacts = $this->leadContacts();

        $this->assertStringContainsString('+7 (495) 123-45-67', $contacts);
        $this->assertStringContainsString('info@iteross.ru', $contacts);
        $this->assertStringContainsString('Дербеневская ул., 12, стр. 3', $contacts);
        $this->assertStringContainsString('ИНН 7700000000', $contacts);
    }

    public function test_admin_can_change_contacts_next_to_the_lead_form(): void
    {
        Storage::fake('local');

        $this->actingAs($this->admin())
            ->post(route('admin.pages.update', ['page' => 'home']), $this->homePayload([
                'phone' => '+7 (812) 555-01-02',
                'phone_note' => 'Ежедневно: 8:00 – 20:00',
                'email' => 'sales@example.com',
                'email_note' => 'Отвечаем за час',
                'address' => 'г. Санкт-Петербург, Невский пр., 1',
                'requisites_name' => 'ООО «ТЕСТ»',
                'requisites_details' => 'ИНН 7811111111 · ОГРН 1027800000000',
            ]))
            ->assertRedirect(route('admin.pages.editor', ['page' => 'home']))
            ->assertSessionHasNoErrors();

        $contacts = $this->leadContacts();

        $this->assertStringContainsString('+7 (812) 555-01-02', $contacts);
        $this->assertStringContainsString('href="tel:+78125550102"', $contacts);
        $this->assertStringContainsString('Ежедневно: 8:00 – 20:00', $contacts);
        $this->assertStringContainsString('href="mailto:sales@example.com"', $contacts);
        $this->assertStringContainsString('Отвечаем за час', $contacts);
        $this->assertStringContainsString('Невский пр., 1', $contacts);
        $this->assertStringContainsString('ООО «ТЕСТ»', $contacts);
        $this->assertStringContainsString('ИНН 7811111111', $contacts);
        $this->assertStringNotContainsString('+7 (495) 123-45-67', $contacts);
        $this->assertStringNotContainsString('info@iteross.ru', $contacts);
        $this->assertStringNotContainsString('Дербеневская', $contacts);
    }

    public function test_empty_contact_fields_are_hidden_on_the_site(): void
    {
        Storage::fake('local');

        $this->actingAs($this->admin())
            ->post(route('admin.pages.update', ['page' => 'home']), $this->homePayload([
                'phone' => '+7 (812) 555-01-02',
                'phone_note' => '',
                'email' => '',
                'email_note' => '',
                'address' => '',
                'requisites_name' => '',
                'requisites_details' => '',
            ]))
            ->assertSessionHasNoErrors();

        $contacts = $this->leadContacts();

        $this->assertStringContainsString('+7 (812) 555-01-02', $contacts);
        $this->assertStringNotContainsString('lead-meta-subtext', $contacts);
        $this->assertStringNotContainsString('Email', $contacts);
        $this->assertStringNotContainsString('Адрес', $contacts);
        $this->assertStringNotContainsString('Реквизиты', $contacts);
        $this->assertStringNotContainsString('info@iteross.ru', $contacts);
        $this->assertStringNotContainsString('Дербеневская', $contacts);
    }

    public function test_invalid_contact_email_is_rejected_with_a_russian_message(): void
    {
        Storage::fake('local');

        $this->actingAs($this->admin())
            ->from(route('admin.pages.editor', ['page' => 'home']))
            ->post(route('admin.pages.update', ['page' => 'home']), $this->homePayload(['email' => 'not-an-email']))
            ->assertSessionHasErrors(['contacts.email' => 'Введите корректный email, например info@iteross.ru.']);

        Storage::disk('local')->assertMissing('page-content/home.json');
    }

    public function test_admin_editor_shows_current_contacts(): void
    {
        Storage::fake('local');

        $this->actingAs($this->admin())
            ->get(route('admin.pages.editor', ['page' => 'home']))
            ->assertOk()
            ->assertSee('name="contacts[phone]"', false)
            ->assertSee('value="+7 (495) 123-45-67"', false)
            ->assertSee('value="info@iteross.ru"', false);
    }

    /**
     * The contacts block next to the lead form (the header and footer repeat some of these values).
     */
    private function leadContacts(): string
    {
        $html = $this->get('/')->assertOk()->getContent();

        $start = strpos($html, 'class="lead-meta"');
        $end = strpos($html, 'class="lead-form-panel"');

        $this->assertNotFalse($start);
        $this->assertNotFalse($end);

        return substr($html, $start, $end - $start);
    }
}
