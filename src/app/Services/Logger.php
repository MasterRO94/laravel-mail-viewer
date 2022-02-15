<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

use MasterRO\MailViewer\Models\MailLog;
use Symfony\Component\Mime\Email;

class Logger
{
    public function __construct(
        protected AddressParser $addressParser,
        protected HeadersParser $headersParser,
        protected AttachmentsParser $attachmentsParser,
    ) {
    }

    public function log(Email $message)
    {
        MailLog::create([
            'from'        => $this->addressParser->parse($message, 'From'),
            'to'          => $this->addressParser->parse($message, 'To'),
            'cc'          => $this->addressParser->parse($message, 'Cc'),
            'bcc'         => $this->addressParser->parse($message, 'Bcc'),
            'subject'     => $message->getSubject(),
            'body'        => $message->getHtmlBody(),
            'payload'     => $message->getBody()->toString(),
            'headers'     => $this->headersParser->parse($message),
            'attachments' => $this->attachmentsParser->parse($message),
            'date'        => now()->toDateTimeString(),
        ]);
    }
}
