<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

use Illuminate\Support\Str;
use Symfony\Component\Mime\Email;

class HeadersParser
{
    public function parse(Email $message): array
    {
        return collect($message->getHeaders()->toArray())
            ->mapWithKeys(static fn(string $header) => [
                Str::before($header, ':') => Str::after($header, ':'),
            ])
            ->toArray();
    }
}
