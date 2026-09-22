<?php

declare(strict_types=1);

namespace Bluezone;

use Bluezone\Resources\ClanResource;
use Bluezone\Resources\MatchResource;
use Bluezone\Resources\PlayerResource;
use Bluezone\Resources\SeasonResource;
use Bluezone\Resources\StatusResource;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;

/**
 * The PUBG API connector.
 *
 * Rate limiting is enforced client-side so a burst never reaches the API's own
 * limiter. The store defaults to memory, which is only correct for a single
 * process; pass a shared store (PredisStore, LaravelCacheStore, FileStore) in
 * any multi-process app.
 */
class Bluezone extends Connector
{
    use AlwaysThrowOnErrors;
    use HasRateLimits;
    use HasTimeout;

    protected int $connectTimeout = 10;

    protected int $requestTimeout = 15;

    public function __construct(
        protected string $apiKey,
        protected ?RateLimitStore $store = null,
        protected int $requestsPerMinute = 10,
    ) {}

    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator($this->apiKey);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.pubg.com';
    }

    /** @return array<string, string> */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.api+json',
        ];
    }

    /** @return array<int, Limit> */
    protected function resolveLimits(): array
    {
        return [
            Limit::allow($this->requestsPerMinute)->everyMinute(),
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return $this->store ?? new MemoryStore;
    }

    public function clan(): ClanResource
    {
        return new ClanResource($this);
    }

    public function match(): MatchResource
    {
        return new MatchResource($this);
    }

    public function player(): PlayerResource
    {
        return new PlayerResource($this);
    }

    public function season(): SeasonResource
    {
        return new SeasonResource($this);
    }

    public function status(): StatusResource
    {
        return new StatusResource($this);
    }
}
