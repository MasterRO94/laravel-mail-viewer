<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

use MasterRO\MailViewer\Models\MailLog;
use Symfony\Component\Mime\Email;

class Logger
{
    public function __construct(
        protected HeadersParser $headersParser,
        protected AttachmentsParser $attachmentsParser,
    ) {}

    public function log(Email $message): void
    {
        MailLog::create([
            'subject' => $message->getSubject(),
            'body' => $message->getHtmlBody(),
            'text' => $message->getTextBody(),
            'payload' => $message->getBody()->toString(),
            'headers' => $this->headersParser->parse($message),
            'attachments' => $this->attachmentsParser->parse($message),
            'date' => now(),
        ]);
    }
}
