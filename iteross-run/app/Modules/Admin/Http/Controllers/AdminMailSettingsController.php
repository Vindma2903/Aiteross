<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Application\UseCases\ApplyMailServerSettings;
use App\Modules\Admin\Application\UseCases\GetMailServerSettings;
use App\Modules\Admin\Application\UseCases\UpdateMailServerSettings;
use App\Modules\Admin\Http\Requests\UpdateMailServerSettingsRequest;
use App\Modules\Admin\Infrastructure\Mail\TestMailServerMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminMailSettingsController extends Controller
{
    public function __construct(
        private readonly GetMailServerSettings $getMailServerSettings,
        private readonly UpdateMailServerSettings $updateMailServerSettings,
        private readonly ApplyMailServerSettings $applyMailServerSettings,
    ) {
    }

    public function index(): View
    {
        $settings = $this->getMailServerSettings->handle();

        return view('admin.mail-server', [
            'settings' => $settings,
            'hasPassword' => filled($settings['password']),
        ]);
    }

    public function update(UpdateMailServerSettingsRequest $request): RedirectResponse
    {
        $this->updateMailServerSettings->handle($request->validated());

        return redirect()
            ->route('admin.mail-server')
            ->with('status', 'Настройки почтового сервера сохранены.');
    }

    public function test(Request $request): RedirectResponse
    {
        $request->validate([
            'test_email' => ['required', 'email', 'max:255'],
        ]);

        $settings = $this->getMailServerSettings->handle();

        if (blank($settings['host'])) {
            return redirect()
                ->route('admin.mail-server')
                ->with('mail_test_error', 'Сначала укажите и сохраните адрес почтового сервера.');
        }

        $this->applyMailServerSettings->handle($settings);

        $testEmail = (string) $request->string('test_email');

        try {
            Mail::to($testEmail)->send(new TestMailServerMessage());
        } catch (\Throwable $exception) {
            return redirect()
                ->route('admin.mail-server')
                ->with('mail_test_error', 'Не удалось отправить письмо: ' . $exception->getMessage());
        }

        return redirect()
            ->route('admin.mail-server')
            ->with('status', 'Тестовое письмо отправлено на ' . $testEmail . '.');
    }
}
