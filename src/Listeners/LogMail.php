<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Listeners;

use Illuminate\Mail\Events\MessageSending;
use MasterRO\MailViewer\Services\Logger;

class LogMail
{
    public function __construct(
        protected Logger $logger,
    ) {}

    public function handle(MessageSending $event): void
    {
        $this->logger->log($event->message);
    }
}
