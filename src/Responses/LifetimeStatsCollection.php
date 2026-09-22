<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Illuminate\Support\Collection;
use Saloon\Http\Response;

final class LifetimeStatsCollection extends PubgResponse
{
    /** @param Collection<int, LifetimeStats> $stats */
    public function __construct(
        public readonly Collection $stats,
    ) {}

    public static function make(Response $response): self
    {
        return new self(
            stats: collect($response->json('data'))->map(LifetimeStats::fromArray(...))->values()
        );
    }
}
