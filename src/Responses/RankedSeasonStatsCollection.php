<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Responses\RankedSeasonStats;
use Illuminate\Support\Collection;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class RankedSeasonStatsCollection extends PubgResponse
{
    public function __construct(
        readonly public Collection $stats,
    ) {
    }

    public static function make(Response $response): self
    {
        return new static(
            stats: collect($response->json()['data'])->map(fn ($p) => RankedSeasonStats::make($p))
        );
    }
}
