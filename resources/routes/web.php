<?php

declare(strict_types=1);

use MasterRO\MailViewer\Controllers\MailController;

Route::group([
    'middleware' => config('mail-viewer.middleware', ['web']),
    'as' => 'mail-viewer::',
    'prefix' => config('mail-viewer.uri_prefix', '_mail-viewer'),
], function () {

    Route::get('/', [MailController::class, 'index'])
        ->name('index');

    Route::get('/emails', [MailController::class, 'emails'])
        ->name('emails');

    Route::get('/stats', [MailController::class, 'stats'])
        ->name('stats');

    Route::get('/emails/{mailLog}/payload', [MailController::class, 'payload'])
        ->name('payload');

    Route::get('/emails/{mailLog}/raw-payload', [MailController::class, 'rawPayload'])
        ->name('rawPayload');

    Route::get('/emails/{mailLog}/attachments', [MailController::class, 'attachments'])
        ->name('payload');

    Route::get('/emails/{mailLog}/attachments/{fileName}', [MailController::class, 'downloadAttachment'])
        ->name('downloadAttachment');
});
