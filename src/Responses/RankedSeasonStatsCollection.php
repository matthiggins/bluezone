<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Illuminate\Support\Collection;
use Saloon\Http\Response;

final class RankedSeasonStatsCollection extends PubgResponse
{
    /** @param Collection<int, RankedSeasonStats> $stats */
    public function __construct(
        public readonly Collection $stats,
    ) {}

    public static function make(Response $response): self
    {
        return new self(
            stats: collect($response->json('data'))->map(RankedSeasonStats::fromArray(...))->values()
        );
    }
}
