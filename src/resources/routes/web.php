<?php

declare(strict_types=1);

Route::group(['middleware' => config('grid.middleware', ['web']), 'as' => 'mail-viewer::', 'prefix' => 'mail-viewer'], function () {
	Route::get('/', '\\MasterRO\\MailViewer\\Controllers\\MailController@index')
		->name('index');
});