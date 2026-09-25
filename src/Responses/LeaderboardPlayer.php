<?php

declare(strict_types=1);

namespace Bluezone\Responses;

/** One row of a leaderboard. PUBG sends `kda` and `killDeathRatio` as 0 for every row, so they are left out. */
final class LeaderboardPlayer
{
    public function __construct(
        public readonly string $accountId,
        public readonly string $name,
        public readonly int $rank,
        public readonly float $rankPoints,
        public readonly RankTier $tier,
        public readonly int $games,
        public readonly int $wins,
        public readonly float $winRatio,
        public readonly int $kills,
        public readonly float $averageKill,
        public readonly float $averageDamage,
        public readonly float $averageRank,
    ) {}

    /** @param array<string, mixed> $player */
    public static function fromArray(array $player): self
    {
        $stats = $player['attributes']['stats'] ?? [];

        return new self(
            accountId: (string) $player['id'],
            name: (string) $player['attributes']['name'],
            rank: (int) $player['attributes']['rank'],
            rankPoints: (float) ($stats['rankPoints'] ?? 0),
            tier: RankTier::fromArray($stats),
            games: (int) ($stats['games'] ?? 0),
            wins: (int) ($stats['wins'] ?? 0),
            winRatio: (float) ($stats['winRatio'] ?? 0),
            kills: (int) ($stats['kills'] ?? 0),
            averageKill: (float) ($stats['averageKill'] ?? 0),
            averageDamage: (float) ($stats['averageDamage'] ?? 0),
            averageRank: (float) ($stats['averageRank'] ?? 0),
        );
    }
}
