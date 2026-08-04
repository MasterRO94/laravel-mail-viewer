<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use MasterRO\MailViewer\Tests\BaseTestCase;

pest()->extend(BaseTestCase::class);

/**
 * Class-string listeners bound to an event, read straight from the dispatcher.
 *
 * @param  class-string  $event
 * @return array<int, string>
 */
function rawStringListeners(string $event): array
{
    return array_values(array_filter(
        Event::getRawListeners()[$event] ?? [],
        'is_string',
    ));
}
