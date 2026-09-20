<?php

namespace App\Modules\LeadRequests\Application\DataTransfer;

use Illuminate\Http\UploadedFile;

final readonly class LeadRequestData
{
    /**
     * @param  list<UploadedFile>  $attachments
     */
    public function __construct(
        public string $companyName,
        public string $phone,
        public string $email,
        public string $taskDescription,
        public array $attachments = [],
    ) {}
}
