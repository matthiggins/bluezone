<?php

declare(strict_types=1);

use Bluezone\Bluezone;
use Saloon\Http\Faking\Fixture;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\MockConfig;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

MockConfig::setFixturePath(__DIR__.'/Fixtures');
MockConfig::throwOnMissingFixtures();

// MemoryStore is static, so state leaks between tests/files unless cleared.
uses()->afterEach(fn () => MemoryStore::clear())->in(__DIR__);

/** A Bluezone connector whose requests are answered by the given mocks. */
function mockBluezone(array $mocks, int $requestsPerMinute = 1000): Bluezone
{
    $bluezone = new Bluezone(apiKey: 'test-api-key', requestsPerMinute: $requestsPerMinute);
    $bluezone->withMockClient(new MockClient($mocks));

    return $bluezone;
}

// Named apiFixture, not fixture: Pest 5 core already declares a global fixture() (browser testing), which fatally collides.
/** A recorded fixture under tests/Fixtures; records on first run when PUBG_API_KEY is set, replays afterwards. */
function apiFixture(string $name): Fixture
{
    return MockResponse::fixture($name);
}

/** A real connector for recording fixtures. Skips the test when no key is set. */
function recordingBluezone(): Bluezone
{
    $key = getenv('PUBG_API_KEY');

    if ($key === false || $key === '') {
        test()->markTestSkipped('PUBG_API_KEY not set; cannot record fixtures.');
    }

    return new Bluezone(apiKey: $key, requestsPerMinute: 1000);
}
