<?php

declare(strict_types=1);

use Bluezone\Responses\Telemetry;
use Bluezone\Telemetry\Events\PhaseChange;
use Bluezone\Telemetry\Events\TelemetryEvent;

it('drops unmapped events and counts them by type', function () {
    $telemetry = Telemetry::fromJson(json_encode([
        ['_T' => 'LogPhaseChange', '_D' => '2026-01-01T00:00:00Z', 'phase' => 1, 'elapsedTime' => 1, 'common' => ['isGame' => 1.0]],
        ['_T' => 'LogSomethingNew', '_D' => '2026-01-01T00:00:01Z'],
        ['_T' => 'LogSomethingNew', '_D' => '2026-01-01T00:00:02Z'],
    ]));

    expect($telemetry->events())->toHaveCount(1)
        ->and($telemetry->events()->first())->toBeInstanceOf(PhaseChange::class)
        ->and($telemetry->unmappedTypes())->toBe(['LogSomethingNew' => 2]);
});

it('maps the raw events only once', function () {
    $telemetry = Telemetry::fromJson(json_encode([
        ['_T' => 'LogPhaseChange', '_D' => '2026-01-01T00:00:00Z', 'phase' => 1, 'elapsedTime' => 1, 'common' => ['isGame' => 1.0]],
    ]));

    expect($telemetry->events()->first())->toBe($telemetry->events()->first());
});

it('keeps every in-game event from the sample fixture parseable', function () {
    $telemetry = Telemetry::fromJson((string) file_get_contents(__DIR__.'/../../Fixtures/telemetry-sample.json'));

    $inGame = $telemetry->eventsDuringGame();

    expect($inGame)->not->toBeEmpty()
        ->and($inGame->every(fn (TelemetryEvent $event): bool => $event->common->isGame >= 1))->toBeTrue()
        ->and($telemetry->unmappedTypes())->toBe([]);
});
