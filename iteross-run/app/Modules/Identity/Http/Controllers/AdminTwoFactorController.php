<?php

namespace App\Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;

class AdminTwoFactorController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('pending_2fa_user_id')) {
            return redirect()->route('admin.login');
        }

        return view('auth.admin-two-factor');
    }

    public function store(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('pending_2fa_user_id');

        if (! $userId) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'code' => ['required', 'string', 'digits:6'],
        ]);

        $user = User::find($userId);

        if (! $user || ! $user->two_factor_enabled) {
            $request->session()->forget('pending_2fa_user_id');

            return redirect()->route('admin.login');
        }

        $google2fa = new Google2FA();

        if (! $google2fa->verifyKey($user->two_factor_secret, $request->code)) {
            return back()->withErrors(['code' => 'Неверный код. Попробуйте ещё раз.']);
        }

        $request->session()->forget('pending_2fa_user_id');
        Auth::loginUsingId($userId);
        $request->session()->regenerate();
        $request->session()->put('two_factor_verified', true);

        return redirect()->route('admin.dashboard');
    }
}
