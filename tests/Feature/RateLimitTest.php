<?php

declare(strict_types=1);

use Bluezone\Bluezone;
use Bluezone\Requests\StatusRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

it('stops sending once the per-minute budget is spent', function () {
    $bluezone = new Bluezone('key', new MemoryStore, requestsPerMinute: 2);
    $bluezone->withMockClient(new MockClient([StatusRequest::class => MockResponse::make(['data' => ['type' => 'status', 'id' => 'pubg-api', 'attributes' => ['releasedAt' => '2026-01-01T00:00:00Z', 'version' => '1']]])]));

    $bluezone->status()->get();
    $bluezone->status()->get();
    $bluezone->status()->get();
})->throws(RateLimitReachedException::class);

it('marks the limit exceeded when the api answers 429', function () {
    $bluezone = new Bluezone('key', new MemoryStore, requestsPerMinute: 100);
    $bluezone->withMockClient(new MockClient([
        StatusRequest::class => MockResponse::make(['errors' => []], 429, ['Retry-After' => '30']),
    ]));

    try {
        // Automatic 429 detection fires this (FIRST-order middleware) before Saloon's own
        // TooManyRequestsException (LAST-order) ever gets a chance to run.
        $bluezone->status()->get();
    } catch (RateLimitReachedException) {
    }

    expect($bluezone->hasReachedRateLimit())->toBeTrue()
        ->and($bluezone->getExceededLimit()->getRemainingSeconds())->toBeGreaterThan(0);
});

it('can be disabled for tests', function () {
    $bluezone = (new Bluezone('key', new MemoryStore, requestsPerMinute: 1))->useRateLimitPlugin(false);
    $bluezone->withMockClient(new MockClient([StatusRequest::class => MockResponse::make(['data' => ['type' => 'status', 'id' => 'pubg-api', 'attributes' => ['releasedAt' => '2026-01-01T00:00:00Z', 'version' => '1']]])]));

    $bluezone->status()->get();
    $bluezone->status()->get();

    expect(true)->toBeTrue();
});
