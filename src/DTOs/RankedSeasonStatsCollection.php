<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

use Bluezone\DTOs\RankedSeasonStats;
use Illuminate\Support\Collection;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class RankedSeasonStatsCollection extends PubgDTO
{
    public function __construct(
        readonly public Collection $stats,
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        return new static(
            stats: collect($response->json()['data'])->map(fn ($p) => RankedSeasonStats::fromResponse($p))
        );
    }
}
