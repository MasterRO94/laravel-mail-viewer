<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Commands;

use Illuminate\Console\Command;
use MasterRO\MailViewer\Models\MailLog;

class PruneCommand extends Command
{
    protected $signature = 'mail-viewer:prune';

    protected $description = 'Prune old records from db.';

    public function handle(): int
    {
        $this->call('model:prune', [
            '----model' => MailLog::class,
        ]);

        return static::SUCCESS;
    }
}
