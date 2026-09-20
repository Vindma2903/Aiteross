<?php

namespace App\Modules\LeadRequests\Application\UseCases;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

final class StoreAttachments
{
    /**
     * @param  list<UploadedFile>  $files
     * @return list<array{disk: string, path: string, original_name: string}>
     */
    public function handle(array $files): array
    {
        $disk = (string) config('services.lead_requests.disk', 'local');
        $directory = trim((string) config('services.lead_requests.directory', 'lead-requests'), '/');

        $stored = [];

        foreach ($files as $file) {
            $path = $file->storeAs(
                $directory,
                sprintf('%s-%s.%s', now()->format('YmdHis'), Str::uuid(), $file->getClientOriginalExtension()),
                $disk,
            );

            if ($path === false) {
                throw new \RuntimeException(sprintf('Could not store attachment "%s" on disk "%s".', $file->getClientOriginalName(), $disk));
            }

            $stored[] = [
                'disk' => $disk,
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ];
        }

        return $stored;
    }
}
