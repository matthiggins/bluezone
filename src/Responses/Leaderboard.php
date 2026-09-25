<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Region;
use Illuminate\Support\Collection;
use Saloon\Http\Response;

/** One region's ranked leaderboard for a season and mode; PUBG returns the whole top 500 in one page. */
final class Leaderboard extends PubgResponse
{
    /** @param Collection<int, LeaderboardPlayer> $players */
    public function __construct(
        public readonly string $id,
        public readonly Region $region,
        public readonly string $seasonId,
        public readonly GameMode $gameMode,
        public readonly Collection $players,
    ) {}

    public static function make(Response $response, Region $region, GameMode $gameMode): self
    {
        return self::fromArray($response->json(), $region, $gameMode);
    }

    /**
     * Region and mode come from the request, not the body, so a shardId or ranked mode the enums lack cannot fail a good response.
     *
     * @param  array<string, mixed>  $body  the decoded response body
     */
    public static function fromArray(array $body, Region $region, GameMode $gameMode): self
    {
        $data = $body['data'];

        // `included` arrives unordered, so the board is sorted by rank here.
        $players = collect($body['included'] ?? [])
            ->where('type', 'player')
            ->map(fn (array $player): LeaderboardPlayer => LeaderboardPlayer::fromArray($player))
            ->sortBy('rank')
            ->values();

        return new self(
            id: $data['id'],
            region: $region,
            seasonId: $data['attributes']['seasonId'],
            gameMode: $gameMode,
            players: $players,
        );
    }
}
