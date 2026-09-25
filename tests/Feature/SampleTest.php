<?php

declare(strict_types=1);

use Bluezone\Enums\Shard;
use Bluezone\Exceptions\InvalidSampleWindowException;
use Bluezone\Requests\SamplesRequest;
use Carbon\Carbon;

beforeEach(fn () => Carbon::setTestNow('2026-09-25 12:00:00 UTC'));
afterEach(fn () => Carbon::setTestNow());

it('lists a shard\'s sampled match ids', function () {
    $samples = mockBluezone([SamplesRequest::class => apiFixture('samples')])->sample()->get('steam');

    expect($samples->shard)->toBe(Shard::Steam)
        ->and($samples->createdAt->toIso8601String())->toBe('2026-09-24T00:00:00+00:00')
        ->and($samples->matchIds)->toHaveCount(798)
        ->and($samples->matchIds->first())->toBe('141d8ab5-626c-4fcc-b77b-1d4edec63c16');
});

it('asks for samples from a given time in the format PUBG expects', function () {
    $bluezone = mockBluezone([SamplesRequest::class => apiFixture('samples')]);

    $bluezone->sample()->get(Shard::Steam, new DateTimeImmutable('2026-09-24 06:30:00', new DateTimeZone('UTC')));

    $bluezone->getMockClient()->assertSent(fn (SamplesRequest $request) => $request->query()->get('filter[createdAt-start]') === '2026-09-24T06:30:00Z');
});

it('converts a non-utc start time to utc', function () {
    $bluezone = mockBluezone([SamplesRequest::class => apiFixture('samples')]);

    $bluezone->sample()->get(Shard::Steam, new DateTimeImmutable('2026-09-24 06:30:00', new DateTimeZone('America/Chicago')));

    $bluezone->getMockClient()->assertSent(fn (SamplesRequest $request) => $request->query()->get('filter[createdAt-start]') === '2026-09-24T11:30:00Z');
});

it('rejects a start time more than 14 days back without sending', function () {
    $bluezone = mockBluezone([SamplesRequest::class => apiFixture('samples')]);

    expect(fn () => $bluezone->sample()->get(Shard::Steam, Carbon::now()->subDays(15)))
        ->toThrow(InvalidSampleWindowException::class, '14 days');

    $bluezone->getMockClient()->assertNothingSent();
});

it('rejects a start time in the future without sending', function () {
    $bluezone = mockBluezone([SamplesRequest::class => apiFixture('samples')]);

    expect(fn () => $bluezone->sample()->get(Shard::Steam, Carbon::now()->addHour()))
        ->toThrow(InvalidSampleWindowException::class, 'future');

    $bluezone->getMockClient()->assertNothingSent();
});
