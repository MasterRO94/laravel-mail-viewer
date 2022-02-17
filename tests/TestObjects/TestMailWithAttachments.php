<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Tests\TestObjects;

use Illuminate\Mail\Mailable;

class TestMailWithAttachments extends Mailable
{
    public function build()
    {
        $this
            ->subject('Test Mail With Attachments')
            ->attach(realpath(__DIR__ . '/../Fixtures/pdf-test.pdf'))
            ->attach(realpath(__DIR__ . '/../Fixtures/parrot.png'))
            ->view('view');
    }
}
