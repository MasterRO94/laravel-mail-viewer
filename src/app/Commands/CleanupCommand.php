<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use MasterRO\MailViewer\Models\MailLog;

/**
 * Class PublishCommand
 *
 * @package MasterRO\MailViewer\Commands
 */
class CleanupCommand extends Command
{
    protected $signature = 'mail-viewer:cleanup
        {days : Delete all mail logs older than days. "0" would delete everything}
        {--force : Do not ask for confirmation}
    ';

    protected $description = 'Deletes old mail logs.';

    public function handle()
    {
        $days = $this->argument('days');

        $date = Carbon::now()->subDays($days);
        $query = MailLog::where('date', '<', $date);

        $this->info(sprintf('Deleting all mail logs older than %s.', $date));

        $this->info(sprintf('Will delete %d logs.', $query->count()));

        if (!$this->option('force') and !$this->confirm('Do you wish to continue?')) {
            $this->info('User aborted');
            return;
        }

        $num = $query->delete();

        $this->info(sprintf('Deleted %d mail logs', $num));

        return;
    }
}
