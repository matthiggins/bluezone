<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Region;
use Illuminate\Support\Collection;
use Saloon\Http\Response;

/** One region's ranked leaderboard for a season and mode; PUBG returns the whole top 500 on page 0. */
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

    public static function make(Response $response): self
    {
        return self::fromArray($response->json());
    }

    /** @param array<string, mixed> $body the decoded response body */
    public static function fromArray(array $body): self
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
            region: Region::from($data['attributes']['shardId']),
            seasonId: $data['attributes']['seasonId'],
            gameMode: GameMode::from($data['attributes']['gameMode']),
            players: $players,
        );
    }
}
