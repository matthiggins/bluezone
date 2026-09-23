<?php

declare(strict_types=1);

use Bluezone\Telemetry\Events\PhaseChange;

it('names circle appearance and shrink from isGame', function () {
    // Telemetry's `phase` ticks up when the circle starts shrinking, so it is not the circle's number.
    $appears = PhaseChange::make(['phase' => 7, 'elapsedTime' => 100, 'common' => ['isGame' => 7.0]]);
    $shrinks = PhaseChange::make(['phase' => 7, 'elapsedTime' => 200, 'common' => ['isGame' => 6.5]]);
    $lobby = PhaseChange::make(['phase' => 1, 'elapsedTime' => 0, 'common' => ['isGame' => 0.1]]);

    expect($appears->name)->toBe('Circle 7 appears')
        ->and($shrinks->name)->toBe('Circle 6 shrinks')
        ->and($lobby->name)->toBe('Lobby');
});
