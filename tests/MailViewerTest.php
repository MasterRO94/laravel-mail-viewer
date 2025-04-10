<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Mail;
use MasterRO\MailViewer\Models\MailLog;
use MasterRO\MailViewer\Tests\TestObjects\TestMailWithAttachments;

test('it receives mail logs', function () {
    $this->sendTestEmails(50);

    $this
        ->get(route('mail-viewer::emails'))
        ->assertOk()
        ->assertJson([
            'hasMoreItems' => true,
            'perPage' => 20,
            'data' => [
                [
                    'subject' => 'Test mail',
                    'to' => [
                        [
                            'email' => 'igoshin18@gmail.com',
                            'name' => 'Roman Ihoshyn',
                        ],
                        [
                            'email' => 'johndoe@email.com',
                            'name' => null,
                        ],
                    ],
                    'cc' => [
                        [
                            'email' => 'cc@email.com',
                            'name' => 'Email CC',
                        ],
                        [
                            'email' => 'johndoecc@email.com',
                            'name' => null,
                        ],
                    ],
                    'bcc' => [
                        [
                            'email' => 'bcc@email.com',
                            'name' => 'Email BCC',
                        ],
                        [
                            'email' => 'johndoebcc@email.com',
                            'name' => null,
                        ],
                    ],
                ],
            ],
        ]);
});

test('it receives mail log attachments', function () {
    Mail::to('igoshin18@gmail.com')->send(new TestMailWithAttachments());

    $this
        ->get(route('mail-viewer::emails'))
        ->assertOk()
        ->assertJson([
            'hasMoreItems' => false,
            'perPage' => 20,
            'data' => [
                [
                    'subject' => 'Test Mail With Attachments',
                    'to' => [
                        [
                            'email' => 'igoshin18@gmail.com',
                        ],
                    ],
                    'attachments' => [
                        [
                            'encoding' => "base64",
                            'filename' => "pdf-test.pdf",
                            'mediaType' => "application",
                            'name' => "pdf-test.pdf",
                            'subtype' => "pdf",
                        ],
                        [
                            'encoding' => "base64",
                            'filename' => "parrot.png",
                            'mediaType' => "image",
                            'name' => "parrot.png",
                            'subtype' => "png",
                        ],
                    ],
                ],
            ],
        ]);
});

test('it receives mail log payload', function () {
    $this->sendTestEmails(1);

    $this
        ->get(route('mail-viewer::payload', MailLog::first()))
        ->assertOk()
        ->assertJsonStructure(['data']);
});

test('it receives mail logs stats', function () {
    $this->travelTo('2022-01-01');
    $this->sendTestEmails(2);

    $this->travelTo('2022-02-01');
    $this->sendTestEmails(2);

    $this->travelTo('2022-02-13');
    $this->sendTestEmails(2);

    $this->travelTo('2022-02-14');
    $this->sendTestEmails(2);

    $this->travelTo('2022-02-15');
    $this->sendTestEmails(2);

    $this->travelTo('2022-02-16');
    $this->sendTestEmails(3);

    $this->travelTo('2022-02-17');
    $this->sendTestEmails(2);

    $this
        ->get(route('mail-viewer::stats'))
        ->assertOk()
        ->assertJson([
            'data' => [
                [
                    'key' => 'today',
                    'value' => 2,
                    'title' => 'Sent today',
                ],
                [
                    'key' => 'yesterday',
                    'value' => 3,
                    'title' => 'Sent yesterday',
                ],
                [
                    'key' => 'this_week',
                    'value' => 9,
                    'title' => 'Sent this week',
                ],
                [
                    'key' => 'this_month',
                    'value' => 13,
                    'title' => 'Sent this month',
                ],
                [
                    'key' => 'this_year',
                    'value' => 15,
                    'title' => 'Sent this year',
                ],
                [
                    'key' => 'total',
                    'value' => 15,
                    'title' => 'Sent total',
                ],
            ],
        ]);
});
