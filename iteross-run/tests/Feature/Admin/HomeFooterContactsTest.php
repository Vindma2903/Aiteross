<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * The site footer (shown on every page) shares the same "Блок 6" contacts as the
 * lead-form section on the home page: Admin → Главная → Контакты и реквизиты.
 */
class HomeFooterContactsTest extends TestCase
{
    use HomeEditorFixtures;
    use RefreshDatabase;

    public function test_footer_shows_default_contacts_until_they_are_edited(): void
    {
        Storage::fake('local');

        $footer = $this->footerHtml('/');

        $this->assertStringContainsString('+7 (495) 123-45-67', $footer);
        $this->assertStringContainsString('info@iteross.ru', $footer);
        $this->assertStringContainsString('Дербеневская ул., 12, стр. 3', $footer);
        $this->assertStringContainsString('ИНН 7700000000', $footer);
        $this->assertStringContainsString('ОГРН 1157700000000', $footer);
        $this->assertStringContainsString('КПП 770001001', $footer);
    }

    public function test_admin_can_change_footer_address_requisites_and_hours(): void
    {
        Storage::fake('local');

        $this->actingAs($this->admin())
            ->post(route('admin.pages.update', ['page' => 'home']), $this->homePayload([
                'phone' => '+7 (812) 555-01-02',
                'phone_note' => 'Ежедневно: 8:00 – 20:00',
                'email' => 'sales@example.com',
                'address' => 'г. Санкт-Петербург, Невский пр., 1',
                'requisites_name' => 'ООО «ТЕСТ»',
                'requisites_details' => "ИНН 7811111111\nОГРН 1027800000000\nКПП 781101001",
            ]))
            ->assertSessionHasNoErrors();

        $footer = $this->footerHtml('/');

        $this->assertStringContainsString('href="tel:+78125550102"', $footer);
        $this->assertStringContainsString('Ежедневно: 8:00 – 20:00', $footer);
        $this->assertStringContainsString('href="mailto:sales@example.com"', $footer);
        $this->assertStringContainsString('Невский пр., 1', $footer);
        $this->assertStringContainsString('ООО «ТЕСТ»', $footer);
        $this->assertStringContainsString('ИНН 7811111111', $footer);
        $this->assertStringContainsString('ОГРН 1027800000000', $footer);
        $this->assertStringContainsString('КПП 781101001', $footer);
        // Newlines in the textarea become line breaks, not one run-on line.
        $this->assertStringContainsString('ИНН 7811111111<br', $footer);
        $this->assertStringNotContainsString('Дербеневская', $footer);
        $this->assertStringNotContainsString('info@iteross.ru', $footer);
    }

    public function test_footer_contacts_also_update_on_other_pages(): void
    {
        Storage::fake('local');

        $this->actingAs($this->admin())
            ->post(route('admin.pages.update', ['page' => 'home']), $this->homePayload([
                'address' => 'г. Казань, ул. Тестовая, 1',
            ]))
            ->assertSessionHasNoErrors();

        $this->assertStringContainsString('ул. Тестовая, 1', $this->footerHtml('/'));
        $this->assertStringContainsString('ул. Тестовая, 1', $this->footerHtml(route('delivery')));
        $this->assertStringContainsString('ул. Тестовая, 1', $this->footerHtml(route('catalog.index')));
    }

    public function test_empty_contact_fields_hide_the_whole_footer_block(): void
    {
        Storage::fake('local');

        $this->actingAs($this->admin())
            ->post(route('admin.pages.update', ['page' => 'home']), $this->homePayload([
                'phone' => '', 'phone_note' => '', 'email' => '', 'email_note' => '', 'address' => '',
                'requisites_name' => '', 'requisites_details' => '',
            ]))
            ->assertSessionHasNoErrors();

        $footer = $this->footerHtml('/');

        $this->assertStringNotContainsString('unified-site-footer__contact', $footer);
        $this->assertStringNotContainsString('unified-site-footer__legal', $footer);
        $this->assertStringNotContainsString('info@iteross.ru', $footer);
        $this->assertStringNotContainsString('Дербеневская', $footer);
    }

    private function footerHtml(string $path): string
    {
        $html = $this->get($path)->assertOk()->getContent();

        $start = strpos($html, 'id="footer"');
        $end = strpos($html, '</footer>', $start);

        $this->assertNotFalse($start, "No <footer> found on {$path}");

        return substr($html, $start, $end - $start);
    }
}
