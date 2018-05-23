<?php

return [
	'table'           => 'mail_logs',
	'uri_prefix'      => '_mail-viewer',
	'middleware'      => ['web'],
	'date_format'     => 'd.m.Y H:i:s',
	'emails_per_page' => 20,
];
