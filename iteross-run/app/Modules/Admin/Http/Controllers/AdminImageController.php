<?php

namespace App\Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminImageController
{
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'file', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;

        $file->move(public_path('home-media'), $filename);

        return response()->json([
            'url' => '/home-media/' . $filename,
        ]);
    }
}
