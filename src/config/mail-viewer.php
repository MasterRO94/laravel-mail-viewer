<?php

return [
    'table'           => 'mail_logs',
    'uri_prefix'      => '_mail-viewer',
    'middleware'      => ['web'],
    'date_format'     => 'd.m.Y',
    'time_format'     => 'H:i:s',
    'emails_per_page' => 20,
];
