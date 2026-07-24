<?php

namespace App\Modules\Identity\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->two_factor_enabled && ! $request->session()->get('two_factor_verified')) {
            Auth::logout();
            $request->session()->put('pending_2fa_user_id', $user->id);

            return redirect()->route('admin.two-factor');
        }

        return $next($request);
    }
}
