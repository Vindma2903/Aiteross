<?php

namespace App\Modules\LeadRequests\Http\Requests;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator;

/**
 * Shared rules for forms that accept several attachments at once.
 *
 * The total size is capped because the mail provider rejects messages over
 * roughly 30 MB once the files are base64-encoded.
 */
trait ValidatesAttachments
{
    public const MAX_ATTACHMENTS = 10;

    public const MAX_ATTACHMENT_KILOBYTES = 20480;

    public const MAX_TOTAL_ATTACHMENT_KILOBYTES = 20480;

    /**
     * @return array<string, array<int, string>>
     */
    protected function attachmentRules(): array
    {
        return [
            'attachments' => ['nullable', 'array', 'max:'.self::MAX_ATTACHMENTS],
            'attachments.*' => ['file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:'.self::MAX_ATTACHMENT_KILOBYTES],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function attachmentMessages(): array
    {
        return [
            'attachments.max' => 'Можно прикрепить не более '.self::MAX_ATTACHMENTS.' файлов.',
            'attachments.*.mimes' => 'Файл «:input» не подходит: разрешены PDF, DOC, DOCX, JPG и PNG.',
            'attachments.*.max' => 'Файл слишком большой: максимум '.(self::MAX_ATTACHMENT_KILOBYTES / 1024).' МБ на файл.',
            'attachments.*.file' => 'Не удалось загрузить один из файлов, попробуйте ещё раз.',
            'attachments.*.uploaded' => 'Не удалось загрузить один из файлов. Возможно, он слишком большой.',
        ];
    }

    protected function validateTotalAttachmentSize(Validator $validator): void
    {
        $files = array_filter(
            (array) $this->file('attachments', []),
            fn ($file): bool => $file instanceof UploadedFile && $file->isValid(),
        );

        $totalBytes = array_sum(array_map(fn (UploadedFile $file): int => (int) $file->getSize(), $files));

        if ($totalBytes > self::MAX_TOTAL_ATTACHMENT_KILOBYTES * 1024) {
            $validator->errors()->add(
                'attachments',
                'Общий размер файлов не должен превышать '.(self::MAX_TOTAL_ATTACHMENT_KILOBYTES / 1024).' МБ.',
            );
        }
    }
}
