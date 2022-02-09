<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Tests\TestObjects;

use Illuminate\Mail\Mailable;

class TestMailable extends Mailable
{
    public function build()
    {
        $this->view('view');
    }
}
