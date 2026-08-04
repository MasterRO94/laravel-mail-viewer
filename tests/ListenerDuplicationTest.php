<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Event;

/**
 * Testbench's default application does not register the framework event provider, so a host
 * application booting one — what `->withEvents()` does in bootstrap/app.php — has to be
 * simulated. Registering it on the already booted application fires its `booted` callback
 * straight away, which is where `configureEmailVerification()` binds the listener.
 */
beforeEach(function () {
    $this->app->register(EventServiceProvider::class);
});

test('it does not duplicate the email verification listener registered by the application', function () {
    $listeners = array_filter(
        rawStringListeners(Registered::class),
        fn (string $listener) => $listener === SendEmailVerificationNotification::class,
    );

    // Two bindings mean two verification emails per registration — the listener has no idempotency.
    expect($listeners)->toHaveCount(1);
});

test('it does not duplicate any listener', function () {
    $duplicated = [];

    foreach (Event::getRawListeners() as $event => $listeners) {
        $strings = array_filter($listeners, 'is_string');

        if (count($strings) !== count(array_unique($strings))) {
            $duplicated[] = $event;
        }
    }

    expect($duplicated)->toBeEmpty();
});
