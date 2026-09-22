<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Illuminate\Support\Collection;
use Saloon\Http\Response;

final class Seasons extends PubgResponse
{
    /** @param Collection<int, Season> $seasons */
    public function __construct(
        public readonly Collection $seasons,
    ) {}

    public static function make(Response $response): self
    {
        $seasons = collect($response->json('data'))->map(fn (array $s) => new Season(
            id: $s['id'],
            isCurrentSeason: $s['attributes']['isCurrentSeason'],
            isOffSeason: $s['attributes']['isOffseason'],
        ))->values();

        return new self($seasons);
    }

    /**
     * Get the current season
     */
    public function currentSeason(): ?Season
    {
        return $this->seasons->firstWhere('isCurrentSeason', true);
    }
}
