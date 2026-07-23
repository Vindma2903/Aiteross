<?php

namespace App\Modules\LeadRequests\Application\DataTransfer;

use Illuminate\Http\UploadedFile;

final readonly class CallbackRequestData
{
    public function __construct(
        public string $name,
        public string $phone,
        public string $description,
        public ?UploadedFile $attachment,
    ) {}
}
