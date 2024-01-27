<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Bluezone;
use Bluezone\Resources\MatchResource;
use Illuminate\Support\Collection;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class Player extends PubgResponse
{
    public function __construct(
        readonly public string $id,
        readonly public string $name,
        readonly public string $shard,
        readonly public string|null $clanId,
        readonly public string|null $banType,
        readonly public Collection $matches,
    ) {
    }

    public static function make(Response $response): self
    {
        $data = $response->json()['data'];

        return self::fromArray($data);
    }

    public static function fromArray(array $data): self
    {
        $matches = collect($data['relationships']['matches']['data'])->map(fn($match) => $match['id']);

        return new static(
            id: $data['id'], 
            name: $data['attributes']['name'], 
            shard: $data['attributes']['shardId'], 
            clanId: $data['attributes']['clanId'] ?? null,
            banType: $data['attributes']['banType'] ?? null,
            matches: $matches
        );
    }

    /**
     * Load match data for recent matches for this player
     *
     * @param Bluezone $bluezone
     * @return Collection
     */
    public function recentMatches(Bluezone $bluezone, int $limit = 20): Collection
    {
        return $this->matches->take($limit)->map(fn($matchId) => $bluezone->match()->find($this->shard, $matchId));
    }
}
