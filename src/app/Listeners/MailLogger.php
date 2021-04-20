<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Listeners;

use Illuminate\Mail\Events\MessageSending;
use MasterRO\MailViewer\Models\MailLog;
use Swift_Message;

class MailLogger
{
    /**
     * Handle the event.
     *
     * @param MessageSending $event
     */
    public function handle(MessageSending $event)
    {
        $message = $event->message;

        MailLog::create([
            'from'        => $this->addressField($message, 'From'),
            'to'          => $this->addressField($message, 'To'),
            'cc'          => $this->addressField($message, 'Cc'),
            'bcc'         => $this->addressField($message, 'Bcc'),
            'subject'     => $message->getSubject(),
            'body'        => $message->getBody(),
            'headers'     => (string) $message->getHeaders(),
            'attachments' => $message->getChildren() ? implode("\n\n", $message->getChildren()) : null,
            'date'        => now()->toDateTimeString(),
        ]);
    }

    /**
     * Format address strings for sender, to, cc, bcc.
     *
     * @param $message
     * @param $field
     *
     * @return null|string
     */
    protected function addressField(Swift_Message $message, $field)
    {
        $headers = $message->getHeaders();

        if (!$headers->has($field)) {
            return null;
        }

        return collect($headers->get($field)->getFieldBodyModel())
            ->map(function ($name, $email) {
                return compact('email', 'name');
            })->values();
    }

}
