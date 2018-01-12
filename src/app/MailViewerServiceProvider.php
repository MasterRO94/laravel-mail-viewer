<?php

namespace MasterRO\MailViewer;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class MailViewerServiceProvider extends EventServiceProvider
{
	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		MessageSending::class => [
			MailLogger::class,
		],
	];


	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		parent::boot();

		$this->publishes([
			__DIR__ . '/../config/mail-viewer.php' => config_path('mail-viewer.php'),
		], 'config');

		$this->publishes([
			__DIR__ . '/../resources/views' => resource_path('views/vendor/mail-viewer'),
		], 'views');

//		$this->publishes([
//			__DIR__ . '/../database/migrations/' => database_path('migrations'),
//		], 'migrations');

		$this->mergeConfigFrom(
			__DIR__ . '/../config/mail-viewer.php', 'mail-viewer'
		);

		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');

		$this->loadRoutesFrom(__DIR__ . '/../resources/routes/web.php');

		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'mail-viewer');
	}
}
