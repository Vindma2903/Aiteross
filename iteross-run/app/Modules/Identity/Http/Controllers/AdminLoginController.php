<?php

namespace App\Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Identity\Http\Requests\AdminLoginRequest;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended($this->redirectPathForRole(Auth::user()->role));
        }

        return view('auth.admin-login');
    }

    public function store(AdminLoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $credentials['role'] = User::ROLE_ADMIN;

        if (! Auth::attempt($credentials, true)) {
            return back()
                ->withErrors([
                    'email' => 'Неверная почта или пароль администратора.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    private function redirectPathForRole(string $role): string
    {
        return $role === User::ROLE_ADMIN
            ? route('admin.dashboard')
            : route('account');
    }
}
