#!/usr/bin/env php
<?php

declare(strict_types=1);

/** Builds tests/Fixtures/telemetry-sample.json from a real telemetry file. Usage: bin/sample-telemetry.php [url] */
require __DIR__.'/../vendor/autoload.php';

use Bluezone\Resources\TelemetryResource;
use Bluezone\TelemetryConnector;

$fixture = json_decode((string) file_get_contents(__DIR__.'/../tests/Fixtures/match.json'), true);
$match = json_decode($fixture['data'], true);
$asset = current(array_filter($match['included'], fn (array $i): bool => $i['type'] === 'asset'));

$url = $argv[1] ?? $asset['attributes']['URL'];

$body = (string) (new TelemetryResource(new TelemetryConnector))->download($url);
$events = json_decode(str_starts_with($body, "\x1f\x8b") ? (string) gzdecode($body) : $body, true, flags: JSON_THROW_ON_ERROR);

$caps = ['LogMatchDefinition' => PHP_INT_MAX, 'LogMatchStart' => PHP_INT_MAX, 'LogMatchEnd' => PHP_INT_MAX, 'LogPhaseChange' => 8, 'LogGameStatePeriodic' => 8];
$seen = [];
$sample = [];

foreach ($events as $event) {
    $type = $event['_T'];
    $seen[$type] = ($seen[$type] ?? 0) + 1;

    if ($seen[$type] <= ($caps[$type] ?? 5)) {
        $sample[] = $event;
    }
}

file_put_contents(__DIR__.'/../tests/Fixtures/telemetry-sample.json', json_encode($sample, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo count($sample).' events sampled from '.count($events).' ('.count($seen)." types)\n";
