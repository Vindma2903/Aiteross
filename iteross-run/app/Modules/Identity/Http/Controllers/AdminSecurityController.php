<?php

namespace App\Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;

class AdminSecurityController extends Controller
{
    private Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function index(Request $request): View
    {
        $qrDataUri = null;
        $setupSecret = $request->session()->get('setup_2fa_secret');

        if ($setupSecret) {
            $url = $this->google2fa->getQRCodeUrl(
                config('app.name', 'АЙТЕРОСС'),
                Auth::user()->email,
                $setupSecret,
            );
            $qrDataUri = $this->generateQrDataUri($url);
        }

        return view('admin.security', [
            'user' => Auth::user(),
            'qrDataUri' => $qrDataUri,
            'setupSecret' => $setupSecret,
        ]);
    }

    public function setup(Request $request): RedirectResponse
    {
        $secret = $this->google2fa->generateSecretKey();
        $request->session()->put('setup_2fa_secret', $secret);

        return redirect()->route('admin.security');
    }

    public function confirm(Request $request): RedirectResponse
    {
        $secret = $request->session()->get('setup_2fa_secret');

        if (! $secret) {
            return redirect()->route('admin.security')
                ->withErrors(['confirm_code' => 'Сессия истекла. Начните настройку заново.']);
        }

        $request->validate([
            'confirm_code' => ['required', 'string', 'digits:6'],
        ]);

        if (! $this->google2fa->verifyKey($secret, $request->confirm_code)) {
            return redirect()->route('admin.security')
                ->withErrors(['confirm_code' => 'Неверный код. Попробуйте ещё раз.']);
        }

        $user = Auth::user();
        $user->two_factor_secret = $secret;
        $user->two_factor_enabled = true;
        $user->save();

        $request->session()->forget('setup_2fa_secret');
        $request->session()->put('two_factor_verified', true);

        return redirect()->route('admin.security')
            ->with('success', 'Двухфакторная аутентификация успешно включена.');
    }

    public function disable(Request $request): RedirectResponse
    {
        $request->validate([
            'disable_code' => ['required', 'string', 'digits:6'],
        ]);

        $user = Auth::user();

        if (! $user->two_factor_enabled) {
            return redirect()->route('admin.security');
        }

        if (! $this->google2fa->verifyKey($user->two_factor_secret, $request->disable_code)) {
            return redirect()->route('admin.security')
                ->withErrors(['disable_code' => 'Неверный код. Двухфакторная аутентификация не отключена.']);
        }

        $user->two_factor_secret = null;
        $user->two_factor_enabled = false;
        $user->save();

        $request->session()->forget('two_factor_verified');

        return redirect()->route('admin.security')
            ->with('success', 'Двухфакторная аутентификация отключена.');
    }

    private function generateQrDataUri(string $url): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(280),
            new SvgImageBackEnd(),
        );
        $writer = new Writer($renderer);
        $svg = $writer->writeString($url);

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
