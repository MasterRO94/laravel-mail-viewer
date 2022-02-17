<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use MasterRO\MailViewer\Providers\MailViewerServiceProvider;
use MasterRO\MailViewer\Tests\TestObjects\TestMailable;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
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

    protected function sendTestEmails(int $count = 1): void
    {
        foreach (range(1, $count) as $i) {
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
        }
    }
}
