<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use MasterRO\MailViewer\Models\MailLog;
use MasterRO\MailViewer\Providers\MailViewerServiceProvider;
use MasterRO\MailViewer\Tests\TestObjects\TestMailable;
use MasterRO\MailViewer\Tests\TestObjects\TestMailableWithAttachments;
use Orchestra\Testbench\TestCase;

class MailLoggerTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            MailViewerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('mail.driver', 'array');
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        View::addLocation(__DIR__ . '/Fixtures');
    }

    public function test_it_logs_mailable_recipients(): void
    {
        Mail::to('igoshin18@gmail.com')->send(new TestMailable());

        $logEntry = MailLog::latest('id')->first();
        $this->assertEquals('igoshin18@gmail.com', $logEntry->to[0]->email);

        Mail::to([
            [
                'email' => 'igoshin18@gmail.com',
                'name'  => 'Roman Ihoshyn',
            ],
        ])
            ->cc([
                [
                    'email' => 'cc@email.com',
                    'name'  => 'Email CC',
                ],
            ])
            ->bcc([
                [
                    'email' => 'bcc@email.com',
                    'name'  => 'Email BCC',
                ],
            ])
            ->send(new TestMailable());

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
        Mail::to('igoshin18@gmail.com')
            ->send(new TestMailableWithAttachments());

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
