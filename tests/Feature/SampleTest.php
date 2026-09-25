<?php

declare(strict_types=1);

use Bluezone\Enums\Shard;
use Bluezone\Requests\SamplesRequest;
use Saloon\Http\Faking\MockClient;

it('lists a shard\'s sampled match ids', function () {
    $samples = mockBluezone([SamplesRequest::class => apiFixture('samples')])->samples()->get('steam');

    expect($samples->shard)->toBe(Shard::Steam)
        ->and($samples->createdAt->toIso8601String())->toBe('2026-09-24T00:00:00+00:00')
        ->and($samples->matchIds)->toHaveCount(798)
        ->and($samples->matchIds->first())->toBe('141d8ab5-626c-4fcc-b77b-1d4edec63c16');
});

it('asks for samples from a given time in the format PUBG expects', function () {
    $mock = new MockClient([SamplesRequest::class => apiFixture('samples')]);
    $bluezone = mockBluezone([]);
    $bluezone->withMockClient($mock);

    $bluezone->samples()->get(Shard::Steam, new DateTimeImmutable('2026-09-24 06:30:00', new DateTimeZone('UTC')));

    $mock->assertSent(fn (SamplesRequest $request) => $request->query()->get('filter[createdAt-start]') === '2026-09-24T06:30:00Z');
});
