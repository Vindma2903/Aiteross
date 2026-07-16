<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended($this->redirectPathForRole(Auth::user()->role));
        }

        return view('auth.user-login');
    }

    public function login(UserLoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $credentials['role'] = User::ROLE_USER;

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Неверная почта или пароль.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('account.index'));
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended($this->redirectPathForRole(Auth::user()->role));
        }

        return view('auth.user-register');
    }

    public function register(UserRegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'first_name' => $request->string('first_name')->toString(),
            'last_name' => $request->string('last_name')->toString(),
            'company_name' => $request->string('company_name')->toString(),
            'phone' => $request->string('phone')->toString(),
            'email' => $request->string('email')->lower()->toString(),
            'password' => Hash::make($request->string('password')->toString()),
            'role' => User::ROLE_USER,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('account.index');
    }

    protected function redirectPathForRole(string $role): string
    {
        return $role === User::ROLE_ADMIN
            ? route('admin.dashboard')
            : route('account.index');
    }
}
