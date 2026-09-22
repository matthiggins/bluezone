<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Resources\MatchResource;
use Illuminate\Support\Collection;
use Saloon\Http\Connector;
use Saloon\Http\Response;

final class Player extends PubgResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $shard,
        public readonly ?string $clanId,
        public readonly ?string $banType,
        public readonly Collection $matches,
    ) {}

    public static function make(Response $response): self
    {
        $data = $response->json()['data'];

        return self::fromArray($data);
    }

    public static function fromArray(array $data): self
    {
        $matches = collect($data['relationships']['matches']['data'])->map(fn ($match) => $match['id']);

        return new self(
            id: $data['id'],
            name: $data['attributes']['name'],
            shard: $data['attributes']['shardId'],
            clanId: $data['attributes']['clanId'] ?? null,
            banType: $data['attributes']['banType'] ?? null,
            matches: $matches
        );
    }

    /**
     * Load match data for recent matches for this player.
     */
    public function recentMatches(Connector $connector, int $limit = 20): Collection
    {
        return $this->matches->take($limit)->map(fn ($matchId) => (new MatchResource($connector))->find($this->shard, $matchId));
    }
}
