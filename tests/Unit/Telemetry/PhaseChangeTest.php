<?php

declare(strict_types=1);

use Bluezone\Telemetry\Events\PhaseChange;

it('names circle appearance and shrink from isGame', function () {
    $appears = PhaseChange::make(['phase' => 1, 'elapsedTime' => 100, 'common' => ['isGame' => 1.0]]);
    $shrinks = PhaseChange::make(['phase' => 1, 'elapsedTime' => 200, 'common' => ['isGame' => 1.5]]);
    $lobby = PhaseChange::make(['phase' => 0, 'elapsedTime' => 0, 'common' => ['isGame' => 0.0]]);

    expect($appears->name)->toBe('Phase 1 circle appears')
        ->and($shrinks->name)->toBe('Phase 1 circle shrinks')
        ->and($lobby->name)->toBe('Phase 0 lobby');
});
