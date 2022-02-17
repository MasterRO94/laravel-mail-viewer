<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Tests;

use Illuminate\Support\Facades\Mail;
use MasterRO\MailViewer\Models\MailLog;
use MasterRO\MailViewer\Tests\TestObjects\TestMail;
use MasterRO\MailViewer\Tests\TestObjects\TestMailWithAttachments;

class MailViewerTest extends BaseTestCase
{
    public function test_it_receives_mail_logs(): void
    {
        $this->sendTestEmails(5);

        $this
            ->get(route('mail-viewer::emails'))
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data'    => [
                    'current_page' => 1,
                    'data'         => [
                        [
                            'subject' => 'Test mail',
                            'to'      => [
                                [
                                    'email' => 'igoshin18@gmail.com',
                                    'name'  => 'Roman Ihoshyn',
                                ],
                            ],
                            'cc'      => [
                                [
                                    'email' => 'cc@email.com',
                                    'name'  => 'Email CC',
                                ],
                            ],
                            'bcc'     => [
                                [
                                    'email' => 'bcc@email.com',
                                    'name'  => 'Email BCC',
                                ],
                            ],
                        ],
                    ],
                    'from'         => 1,
                    'last_page'    => 1,
                    'per_page'     => 20,
                    'to'           => 5,
                    'total'        => 5,
                ],
            ]);
    }

    public function test_it_receives_mail_log_attachments(): void
    {
        Mail::to('igoshin18@gmail.com')->send(new TestMailWithAttachments());

        $this
            ->get(route('mail-viewer::emails'))
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data'    => [
                    'current_page' => 1,
                    'data'         => [
                        [
                            'subject'     => 'Test Mail With Attachments',
                            'to'          => [
                                [
                                    'email' => 'igoshin18@gmail.com',
                                ],
                            ],
                            'attachments' => [
                                [
                                    'encoding'  => "base64",
                                    'filename'  => "pdf-test.pdf",
                                    'mediaType' => "application",
                                    'name'      => "pdf-test.pdf",
                                    'subtype'   => "pdf",
                                ],
                                [
                                    'encoding'  => "base64",
                                    'filename'  => "parrot.png",
                                    'mediaType' => "image",
                                    'name'      => "parrot.png",
                                    'subtype'   => "png",
                                ],
                            ],
                        ],
                    ],
                    'from'         => 1,
                    'last_page'    => 1,
                    'per_page'     => 20,
                    'to'           => 1,
                    'total'        => 1,
                ],
            ]);
    }

    public function test_it_receives_mail_log_payload(): void
    {
        $this->sendTestEmails(1);

        $this
            ->get(route('mail-viewer::payload', MailLog::first()))
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'data',
            ]);
    }

    public function test_it_receives_mail_logs_stats(): void
    {
        $this->travelTo('2022-01-01');
        Mail::to('igoshin18@gmail.com')->send(new TestMail());
        Mail::to('igoshin18@gmail.com')->send(new TestMail());

        $this->travelTo('2022-02-01');
        Mail::to('igoshin18@gmail.com')->send(new TestMail());
        Mail::to('igoshin18@gmail.com')->send(new TestMail());

        $this->travelTo('2022-02-13');
        Mail::to('igoshin18@gmail.com')->send(new TestMail());
        Mail::to('igoshin18@gmail.com')->send(new TestMail());

        $this->travelTo('2022-02-14');
        Mail::to('igoshin18@gmail.com')->send(new TestMail());
        Mail::to('igoshin18@gmail.com')->send(new TestMail());

        $this->travelTo('2022-02-15');
        Mail::to('igoshin18@gmail.com')->send(new TestMail());
        Mail::to('igoshin18@gmail.com')->send(new TestMail());

        $this->travelTo('2022-02-17');
        Mail::to('igoshin18@gmail.com')->send(new TestMail());
        Mail::to('igoshin18@gmail.com')->send(new TestMail());

        $this
            ->get(route('mail-viewer::stats'))
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data'    => [
                    'Today'      => 2,
                    'This Week'  => 6,
                    'This Month' => 10,
                ],
            ]);
    }
}
