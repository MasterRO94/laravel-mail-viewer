<?php

declare(strict_types=1);

Route::group([
	'middleware' => config('grid.middleware', ['web']),
	'as'         => 'mail-viewer::',
	'prefix'     => config('grid.uri_prefix', '_mail-viewer'),
], function () {

	Route::get('/', '\\MasterRO\\MailViewer\\Controllers\\MailController@index')
		->name('index');
	Route::get('/{mailLog}', '\\MasterRO\\MailViewer\\Controllers\\MailController@show')
		->name('show');
});
