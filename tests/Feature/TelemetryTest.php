<?php

declare(strict_types=1);

use Bluezone\Exceptions\InvalidTelemetryUrlException;
use Bluezone\Requests\TelemetryDownloadRequest;
use Bluezone\TelemetryConnector;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

const TELEMETRY_URL = 'https://telemetry-cdn.pubg.com/bluehole-pubg/steam/2026/09/21/21/01/8c9edeeb-b5ff-11f1-bf2a-9ec49aed1ad5-telemetry.json';

it('rejects urls that are not on the telemetry cdn', function () {
    new TelemetryDownloadRequest('https://evil.example/telemetry.json');
})->throws(InvalidTelemetryUrlException::class);

it('requests the path on the cdn without auth and asks for gzip', function () {
    $connector = new TelemetryConnector;
    $connector->withMockClient(new MockClient([TelemetryDownloadRequest::class => MockResponse::make('[]')]));

    $connector->send(new TelemetryDownloadRequest(TELEMETRY_URL));
    $pending = $connector->getMockClient()->getLastPendingRequest();

    expect($pending->getUrl())->toBe(TELEMETRY_URL)
        ->and($pending->headers()->get('Authorization'))->toBeNull()
        ->and($pending->headers()->get('Accept-Encoding'))->toBe('gzip')
        ->and($pending->config()->get('stream'))->toBeTrue()
        ->and($pending->config()->get('decode_content'))->toBeFalse();
});
