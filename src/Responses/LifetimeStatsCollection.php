<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Illuminate\Support\Collection;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class LifetimeStatsCollection extends PubgResponse
{
    public function __construct(
        readonly public Collection $stats,
    ) {
    }

    public static function make(Response $response): self
    {
        return new static(
            stats: collect($response->json()['data'])->map(fn ($p) => LifetimeStats::fromArray($p))
        );
    }
}
