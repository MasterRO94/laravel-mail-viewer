<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Tests;

use Illuminate\Support\Facades\Mail;
use MasterRO\MailViewer\Models\MailLog;
use MasterRO\MailViewer\Tests\TestObjects\TestMailable;

class MailViewerTest extends BaseTestCase
{
    public function test_it_receives_mail_logs(): void
    {


        $logEntry = MailLog::latest('id')->first();
        $this->assertEquals('igoshin18@gmail.com', $logEntry->to[0]->email);
        $this->assertEquals('Test mail', $logEntry->subject);
        $this->assertEquals('Roman Ihoshyn', $logEntry->to[0]->name);
        $this->assertEquals('cc@email.com', $logEntry->cc[0]->email);
        $this->assertEquals('Email CC', $logEntry->cc[0]->name);
        $this->assertEquals('bcc@email.com', $logEntry->bcc[0]->email);
        $this->assertEquals('Email BCC', $logEntry->bcc[0]->name);
    }
}
