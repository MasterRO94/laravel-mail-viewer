<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Mail;
use MasterRO\MailViewer\Models\MailLog;
use MasterRO\MailViewer\Tests\TestObjects\TestMail;
use MasterRO\MailViewer\Tests\TestObjects\TestMailWithAttachments;

test('it logs mailable recipients', function () {
    Mail::to('igoshin18@gmail.com')->send(new TestMail());

    $logEntry = MailLog::latest('id')->first();
    expect($logEntry->to[0]->email)->toEqual('igoshin18@gmail.com');

    $this->sendTestEmails();

    $logEntry = MailLog::latest('id')->first();
    expect($logEntry->subject)->toEqual('Test mail');
    expect($logEntry->to[0]->email)->toEqual('igoshin18@gmail.com');
    expect($logEntry->to[0]->name)->toEqual('Roman Ihoshyn');
    expect($logEntry->to[1]->email)->toEqual('johndoe@email.com');
    expect($logEntry->to[1]->name)->toBeNull();
    expect($logEntry->cc[0]->email)->toEqual('cc@email.com');
    expect($logEntry->cc[0]->name)->toEqual('Email CC');
    expect($logEntry->cc[1]->email)->toEqual('johndoecc@email.com');
    expect($logEntry->cc[1]->name)->toBeNull();
    expect($logEntry->bcc[0]->email)->toEqual('bcc@email.com');
    expect($logEntry->bcc[0]->name)->toEqual('Email BCC');
    expect($logEntry->bcc[1]->email)->toEqual('johndoebcc@email.com');
    expect($logEntry->bcc[1]->name)->toBeNull();
});

test('it logs attachments', function () {
    Mail::to('igoshin18@gmail.com')->send(new TestMailWithAttachments());

    $logEntry = MailLog::latest('id')->first();

    expect($logEntry->to[0]->email)->toEqual('igoshin18@gmail.com');

    expect($logEntry->attachments[0]['name'])->toEqual('pdf-test.pdf');
    expect($logEntry->attachments[0]['filename'])->toEqual('pdf-test.pdf');
    expect($logEntry->attachments[0]['subtype'])->toEqual('pdf');
    expect($logEntry->attachments[0]['mediaType'])->toEqual('application');

    expect($logEntry->attachments[1]['name'])->toEqual('parrot.png');
    expect($logEntry->attachments[1]['filename'])->toEqual('parrot.png');
    expect($logEntry->attachments[1]['subtype'])->toEqual('png');
    expect($logEntry->attachments[1]['mediaType'])->toEqual('image');
});
