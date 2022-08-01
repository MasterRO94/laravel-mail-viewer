<?php

return [
    'table'                 => 'mail_logs',
    'uri_prefix'            => '_mail-viewer',
    'middleware'            => ['web'],
    'date_format'           => 'd.m.Y',
    'time_format'           => 'H:i:s',
    'timezone'              => env('MAIL_VIEWER_TIMEZONE', env('APP_TIMEZONE', 'UTC')),
    'emails_per_page'       => 20,
    'prune_older_than_days' => 31,
    'site_url'              => null,
];
