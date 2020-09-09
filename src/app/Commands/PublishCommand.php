<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Commands;

use Illuminate\Console\Command;

/**
 * Class PublishCommand
 *
 * @package MasterRO\MailViewer\Commands
 */
class PublishCommand extends Command
{
    protected $signature = 'mail-viewer:publish {--views : Also publish mail-viewer views}';

    protected $description = 'Publish mail-viewer assets configs and optionally views.';

    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'mail-viewer-assets',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'mail-viewer-config',
        ]);

        if ($this->option('views')) {
            $this->call('vendor:publish', [
                '--tag' => 'mail-viewer-views',
                '--force' => true,
            ]);
        }
    }
}
