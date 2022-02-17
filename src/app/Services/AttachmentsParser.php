<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\AbstractPart;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\TextPart;

class AttachmentsParser
{
    public function parse(Email $message): array
    {
        if (! $message->getAttachments()) {
            return [];
        }

        // Symfony DataPart classes don't provide public access to underlying fields.
        // Converting to array works faster than Reflection.
        $privateKeyPrefixes = [
            sprintf("\x00%s\x00", AbstractPart::class),
            sprintf("\x00%s\x00", DataPart::class),
            sprintf("\x00%s\x00", TextPart::class),
        ];

        return collect($message->getAttachments())
            ->map(fn(DataPart $attachment) => collect((array) $attachment)
                ->mapWithKeys(fn($value, $key) => [
                    str_replace($privateKeyPrefixes, '', $key) => $value,
                ])
                ->only(['filename', 'name', 'mediaType', 'subtype', 'encoding']),
            )
            ->toArray();
    }
}
