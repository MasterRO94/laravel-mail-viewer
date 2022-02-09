<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Collection;
use MasterRO\MailViewer\Models\MailLog;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\AbstractPart;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\TextPart;

class MailLogger
{
    public function handle(MessageSending $event): void
    {
        $message = $event->message;

        MailLog::create([
            'from'        => $this->addressField($message, 'From'),
            'to'          => $this->addressField($message, 'To'),
            'cc'          => $this->addressField($message, 'Cc'),
            'bcc'         => $this->addressField($message, 'Bcc'),
            'subject'     => $message->getSubject(),
            'body'        => $message->getBody()->toString(),
            'headers'     => $message->getHeaders()->toString(),
            'attachments' => $this->collectAttachments($message),
            'date'        => now()->toDateTimeString(),
        ]);
    }

    protected function addressField(Email $message, string $field): ?Collection
    {
        $headers = $message->getHeaders();

        if (!$headers->has($field)) {
            return null;
        }

        return collect($headers->get($field)->getBody())
            ->map(function (Address $address) {
                return [
                    'email' => $address->getAddress(),
                    'name'  => $address->getName(),
                ];
            })->values();
    }

    protected function collectAttachments(Email $message): array
    {
        if (!$message->getAttachments()) {
            return [];
        }

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
