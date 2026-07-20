<?php

namespace App\Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Favorites\Application\UseCases\MergeGuestFavoritesIntoUser;
use App\Modules\Identity\Http\Requests\LoginUserRequest;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended($this->redirectPathForRole((string) Auth::user()->role));
        }

        return view('auth.login');
    }

    public function store(LoginUserRequest $request, MergeGuestFavoritesIntoUser $mergeGuestFavoritesIntoUser): RedirectResponse
    {
        $credentials = $request->validated();
        $credentials['role'] = User::ROLE_USER;
        $guestSessionId = $request->session()->getId();

        if (! Auth::attempt($credentials, true)) {
            return back()
                ->withErrors([
                    'email' => 'Неверная почта или пароль.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $mergeGuestFavoritesIntoUser->handle($guestSessionId, $request->user());

        return redirect()->intended(route('account'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function redirectPathForRole(string $role): string
    {
        return $role === User::ROLE_ADMIN
            ? route('admin.dashboard')
            : route('account');
    }
}
