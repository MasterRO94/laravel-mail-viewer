<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Tests\TestObjects;

use Illuminate\Mail\Mailable;

class TestMailableWithAttachments extends Mailable
{
    public function build()
    {
        $this
            ->attach(realpath(__DIR__ . '/../Fixtures/pdf-test.pdf'))
            ->attach(realpath(__DIR__ . '/../Fixtures/parrot.png'))
            ->view('view');
    }
}
