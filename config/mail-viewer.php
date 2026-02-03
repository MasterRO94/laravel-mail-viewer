<?php

declare(strict_types=1);

return [
    'table' => 'mail_logs',
    'middleware' => ['web'],
    'uri_prefix' => env('MAIL_VIEWER_URI_PREFIX', '_mail-viewer'),
    'date_format' => env('MAIL_VIEWER_DATE_FORMAT', 'd.m.Y'),
    'time_format' => env('MAIL_VIEWER_DATE_FORMAT', 'H:i:s'),
    'timezone' => env('MAIL_VIEWER_TIMEZONE', env('APP_TIMEZONE', 'UTC')),
    'emails_per_page' => env('MAIL_VIEWER_EMAILS_PER_PAGE', 20),
    'prune_older_than_days' => env('MAIL_VIEWER_PRUNE_OLDER_THAN_DAYS', 0),
    'site_url' => env('MAIL_VIEWER_SITE_URL'),
];
