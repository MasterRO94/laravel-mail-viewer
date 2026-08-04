<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Providers;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use MasterRO\MailViewer\Commands\PruneCommand;
use MasterRO\MailViewer\Commands\PublishCommand;
use MasterRO\MailViewer\Listeners\LogMail;
use MasterRO\MailViewer\Services\AddressParser;
use MasterRO\MailViewer\Services\AttachmentsParser;
use MasterRO\MailViewer\Services\HeadersParser;
use MasterRO\MailViewer\Services\Logger;

class MailViewerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped(AddressParser::class);
        $this->app->scoped(AttachmentsParser::class);
        $this->app->scoped(HeadersParser::class);
        $this->app->scoped(Logger::class);

        $this->commands([
            PublishCommand::class,
            PruneCommand::class,
        ]);
    }

    public function boot(): void
    {
        Event::listen(MessageSending::class, LogMail::class);

        $this->publish();

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/mail-viewer.php',
            'mail-viewer',
        );

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/');

        $this->loadRoutesFrom(__DIR__ . '/../../resources/routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'mail-viewer');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'mail-viewer');
    }

    protected function publish(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/mail-viewer.php' => $this->app->configPath('mail-viewer.php'),
        ], 'mail-viewer-config');

        $this->publishes([
            __DIR__ . '/../../resources/views' => $this->app->resourcePath('views/vendor/mail-viewer'),
        ], ['mail-viewer-views']);

        $this->publishes([
            __DIR__ . '/../../public/' => $this->app->publicPath('vendor/mail-viewer'),
        ], ['mail-viewer-assets', 'laravel-assets']);
    }
}
