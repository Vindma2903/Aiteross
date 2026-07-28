<?php

namespace App\Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountUpdateController extends Controller
{
    public function profile(Request $request): JsonResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:200', 'unique:users,email,' . $request->user()->id],
            'phone'      => ['nullable', 'string', 'max:30'],
        ]);

        $request->user()->update($data);

        return response()->json(['ok' => true]);
    }

    public function password(Request $request): JsonResponse
    {
        $request->validate([
            'current_password'      => ['required', 'string'],
            'password'              => ['required', 'confirmed', Password::min(8)],
            'password_confirmation' => ['required', 'string'],
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return response()->json(['ok' => false, 'error' => 'Неверный текущий пароль'], 422);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['ok' => true]);
    }
}
