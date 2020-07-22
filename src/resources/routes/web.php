<?php

declare(strict_types=1);

Route::group([
    'middleware' => config('mail-viewer.middleware', ['web']),
    'as'         => 'mail-viewer::',
    'prefix'     => config('mail-viewer.uri_prefix', '_mail-viewer'),
], function () {

    Route::get('/', '\\MasterRO\\MailViewer\\Controllers\\MailController@index')
        ->name('index');

    Route::get('/emails', '\\MasterRO\\MailViewer\\Controllers\\MailController@emails')
        ->name('emails');

    Route::get('/{mailLog}', '\\MasterRO\\MailViewer\\Controllers\\MailController@show')
        ->name('show');
});
