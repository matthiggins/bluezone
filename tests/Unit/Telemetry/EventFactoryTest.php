<?php

declare(strict_types=1);

use Bluezone\Telemetry\Events\EventFactory;
use Bluezone\Telemetry\Events\TelemetryEvent;

$sample = json_decode(file_get_contents(__DIR__.'/../../Fixtures/telemetry-sample.json'), true);

it('maps every event type present in the sample', function () use ($sample) {
    $unmapped = [];

    foreach ($sample as $event) {
        if (EventFactory::make($event) === null) {
            $unmapped[$event['_T']] = true;
        }
    }

    expect(array_keys($unmapped))->toBe([]);
})->note('Every _T in a real 2026 telemetry file must have a DTO; add a class rather than allow-listing here.');

it('returns null for unknown types instead of a raw array', function () {
    expect(EventFactory::make(['_T' => 'LogSomethingNew', '_D' => '2026-01-01T00:00:00Z']))->toBeNull()
        ->and(EventFactory::supports('LogSomethingNew'))->toBeFalse()
        ->and(EventFactory::supports('LogPlayerKillV2'))->toBeTrue();
});

it('stamps event type and date', function () use ($sample) {
    $event = EventFactory::make($sample[0]);

    // _D carries sub-second precision that toIso8601ZuluString() truncates.
    expect($event)->toBeInstanceOf(TelemetryEvent::class)
        ->and($event->eventType)->toBe($sample[0]['_T'])
        ->and($event->date?->toIso8601ZuluString())->toBe(substr($sample[0]['_D'], 0, 19).'Z');
});
