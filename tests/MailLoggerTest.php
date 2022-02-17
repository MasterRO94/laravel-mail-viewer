<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Tests;

use Illuminate\Support\Facades\Mail;
use MasterRO\MailViewer\Models\MailLog;
use MasterRO\MailViewer\Tests\TestObjects\TestMail;
use MasterRO\MailViewer\Tests\TestObjects\TestMailWithAttachments;

class MailLoggerTest extends BaseTestCase
{
    public function test_it_logs_mailable_recipients(): void
    {
        Mail::to('igoshin18@gmail.com')->send(new TestMail());

        $logEntry = MailLog::latest('id')->first();
        $this->assertEquals('igoshin18@gmail.com', $logEntry->to[0]->email);

        $this->sendTestEmails();

        $logEntry = MailLog::latest('id')->first();
        $this->assertEquals('igoshin18@gmail.com', $logEntry->to[0]->email);
        $this->assertEquals('Test mail', $logEntry->subject);
        $this->assertEquals('Roman Ihoshyn', $logEntry->to[0]->name);
        $this->assertEquals('cc@email.com', $logEntry->cc[0]->email);
        $this->assertEquals('Email CC', $logEntry->cc[0]->name);
        $this->assertEquals('bcc@email.com', $logEntry->bcc[0]->email);
        $this->assertEquals('Email BCC', $logEntry->bcc[0]->name);
    }

    public function test_it_logs_attachments(): void
    {
        Mail::to('igoshin18@gmail.com')->send(new TestMailWithAttachments());

        $logEntry = MailLog::latest('id')->first();

        $this->assertEquals('igoshin18@gmail.com', $logEntry->to[0]->email);

        $this->assertEquals('pdf-test.pdf', $logEntry->attachments[0]['name']);
        $this->assertEquals('pdf-test.pdf', $logEntry->attachments[0]['filename']);
        $this->assertEquals('pdf', $logEntry->attachments[0]['subtype']);
        $this->assertEquals('application', $logEntry->attachments[0]['mediaType']);

        $this->assertEquals('parrot.png', $logEntry->attachments[1]['name']);
        $this->assertEquals('parrot.png', $logEntry->attachments[1]['filename']);
        $this->assertEquals('png', $logEntry->attachments[1]['subtype']);
        $this->assertEquals('image', $logEntry->attachments[1]['mediaType']);
    }
}
