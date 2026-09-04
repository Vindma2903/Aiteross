<?php

namespace Tests\Feature\Admin;

use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MailServerSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_save_mail_server_settings(): void
    {
        Storage::fake('local');

        $admin = User::query()->create([
            'name' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+7 (999) 000-00-00',
            'role' => User::ROLE_ADMIN,
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $indexResponse = $this->actingAs($admin)->get(route('admin.mail-server'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('Почтовый сервер');
        $indexResponse->assertSee('Не настроен');

        $updateResponse = $this->actingAs($admin)->post(route('admin.mail-server.update'), [
            'host' => 'smtp.yandex.ru',
            'port' => '465',
            'encryption' => 'ssl',
            'username' => 'noreply@iteross.ru',
            'password' => 'super-secret',
            'from_address' => 'noreply@iteross.ru',
            'from_name' => 'АЙТЕРОСС',
        ]);

        $updateResponse->assertRedirect(route('admin.mail-server'));
        $updateResponse->assertSessionHas('status', 'Настройки почтового сервера сохранены.');

        Storage::disk('local')->assertExists('settings/mail-server.json');
        $stored = json_decode(Storage::disk('local')->get('settings/mail-server.json'), true);

        $this->assertSame('smtp.yandex.ru', $stored['host']);
        $this->assertNotSame('super-secret', $stored['password']);
        $this->assertSame('super-secret', Crypt::decryptString($stored['password']));

        $secondIndexResponse = $this->actingAs($admin)->get(route('admin.mail-server'));
        $secondIndexResponse->assertOk();
        $secondIndexResponse->assertSee('Настроен');
        $secondIndexResponse->assertDontSee('super-secret');

        $blankPasswordUpdate = $this->actingAs($admin)->post(route('admin.mail-server.update'), [
            'host' => 'smtp.yandex.ru',
            'port' => '465',
            'encryption' => 'ssl',
            'username' => 'noreply@iteross.ru',
            'password' => '',
            'from_address' => 'noreply@iteross.ru',
            'from_name' => 'АЙТЕРОСС',
        ]);
        $blankPasswordUpdate->assertRedirect(route('admin.mail-server'));

        $storedAfterBlank = json_decode(Storage::disk('local')->get('settings/mail-server.json'), true);
        $this->assertSame('super-secret', Crypt::decryptString($storedAfterBlank['password']));

        Mail::fake();

        $testResponse = $this->actingAs($admin)->post(route('admin.mail-server.test'), [
            'test_email' => 'check@example.com',
        ]);

        $testResponse->assertRedirect(route('admin.mail-server'));
        $testResponse->assertSessionHas('status');
        Mail::assertSent(\App\Modules\Admin\Infrastructure\Mail\TestMailServerMessage::class);

        $this->assertSame('smtp', config('mail.default'));
        $this->assertSame('smtp.yandex.ru', config('mail.mailers.smtp.host'));
        $this->assertSame('smtps', config('mail.mailers.smtp.scheme'));
    }

    public function test_regular_user_cannot_view_mail_server_settings(): void
    {
        $user = User::query()->create([
            'name' => 'User',
            'first_name' => 'Regular',
            'last_name' => 'User',
            'company' => 'Iteross',
            'phone' => '+7 (999) 111-11-11',
            'role' => User::ROLE_USER,
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.mail-server'));

        $response->assertRedirect(route('account'));
    }
}
