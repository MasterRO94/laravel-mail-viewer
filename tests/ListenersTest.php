<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Mail\Events\MessageSending;
use MasterRO\MailViewer\Listeners\LogMail;

test('it does not register the email verification listener', function () {
    // The package has no business binding SendEmailVerificationNotification at all — the host
    // application registers it itself. Assert against the dispatcher, not the provider's own
    // $listen array, since that distinction is exactly what Laravel's guard gets wrong.
    $listeners = array_filter(
        rawStringListeners(Registered::class),
        fn (string $listener) => $listener === SendEmailVerificationNotification::class,
    );

    expect($listeners)->toBeEmpty();
});

test('it registers the mail logging listener', function () {
    expect(rawStringListeners(MessageSending::class))->toContain(LogMail::class);
});
