<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        User::create([
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'company' => $validated['company'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Регистрация завершена. Теперь войдите в аккаунт.');
    }
}
