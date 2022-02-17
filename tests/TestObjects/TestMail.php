<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Tests\TestObjects;

use Illuminate\Mail\Mailable;

class TestMail extends Mailable
{
    public function build()
    {
        $this
            ->subject('Test mail')
            ->view('view');
    }
}
