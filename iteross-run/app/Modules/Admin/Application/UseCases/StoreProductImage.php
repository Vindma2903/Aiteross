<?php

namespace App\Modules\Admin\Application\UseCases;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreProductImage
{
    public function handle(UploadedFile $file, ?string $currentImage = null): string
    {
        $path = $file->store('product-images', 'public');

        if ($currentImage !== null && str_starts_with($currentImage, '/storage/product-images/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $currentImage));
        }

        return '/storage/'.$path;
    }
}
