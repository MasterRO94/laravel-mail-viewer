<?php

namespace MasterRO\MailableViewer;

use Illuminate\Support\ServiceProvider;

class MailableViewerServiceProvider extends ServiceProvider
{
	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../mailable-viewer.php' => config_path('mailable-viewer.php'),
		]);
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}