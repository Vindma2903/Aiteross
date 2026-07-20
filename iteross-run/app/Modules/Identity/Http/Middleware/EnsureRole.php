<?php

namespace App\Modules\Identity\Http\Middleware;

use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if (! in_array($user->role, $roles, true)) {
            return $this->redirectByRole($user->role);
        }

        return $next($request);
    }

    private function redirectByRole(string $role): RedirectResponse
    {
        return redirect()->to(
            $role === User::ROLE_ADMIN
                ? route('admin.dashboard')
                : route('account'),
        );
    }
}
