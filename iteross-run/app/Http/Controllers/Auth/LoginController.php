<?php

namespace App\Http\Controllers\Auth;

use App\Application\Favorites\FavoriteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginUserRequest $request, FavoriteService $favoriteService): RedirectResponse
    {
        $credentials = $request->validated();
        $guestSessionId = $request->session()->getId();

        if (! Auth::attempt($credentials, true)) {
            return back()
                ->withErrors([
                    'email' => 'Неверная почта или пароль.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $favoriteService->mergeGuestFavoritesIntoUser($guestSessionId, $request->user());

        return redirect()->intended('/');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
