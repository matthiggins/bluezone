<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Illuminate\Support\Collection;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class Seasons extends PubgResponse
{
    public function __construct(
        readonly public Collection $seasons,
    ) {
    }

    public static function make(Response $response): self
    {
        $data = $response->json()['data'];

        $seasons = collect($data)->map(function ($s) {
            return new Season(
                id: $s['id'],
                isCurrentSeason: $s['attributes']['isCurrentSeason'],
                isOffSeason: $s['attributes']['isOffseason'],
            );
        });

        return new static($seasons);
    }

    /**
     * Get the current season
     */
    public function currentSeason(): Season
    {
        return $this->seasons->firstWhere('isCurrentSeason', true);
    }
}
