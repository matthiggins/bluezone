<?php

declare(strict_types=1);

namespace Bluezone\Responses;

final class RankedGameModeStats extends PubgResponse
{
    public function __construct(
        public readonly RankTier $currentTier,
        public readonly int $currentRankPoint,
        public readonly RankTier $bestTier,
        public readonly int $bestRankPoint,
        public readonly int $roundsPlayed,
        public readonly float $avgRank,
        public readonly float $avgSurvivalTime,
        public readonly float $top10Ratio,
        public readonly float $winRatio,
        public readonly int $assists,
        public readonly int $wins,
        public readonly float $kda,
        public readonly float $kdr,
        public readonly float $avgKill,
        public readonly int $kills,
        public readonly int $deaths,
        public readonly int $roundMostKills,
        public readonly float $longestKill,
        public readonly int $headshotKills,
        public readonly float $headshotKillRatio,
        public readonly float $damageDealt,
        public readonly int $dBNOs,
        public readonly float $reviveRatio,
        public readonly int $revives,
        public readonly int $heals,
        public readonly int $boosts,
        public readonly int $weaponsAcquired,
        public readonly int $teamKills,
        public readonly float $playTime,
        public readonly int $killStreak,
    ) {}

    /** @param array<string, mixed> $d */
    public static function fromArray(array $d): self
    {
        return new self(
            currentTier: RankTier::fromArray($d['currentTier'] ?? []),
            currentRankPoint: (int) ($d['currentRankPoint'] ?? 0),
            bestTier: RankTier::fromArray($d['bestTier'] ?? []),
            bestRankPoint: (int) ($d['bestRankPoint'] ?? 0),
            roundsPlayed: (int) ($d['roundsPlayed'] ?? 0),
            avgRank: (float) ($d['avgRank'] ?? 0),
            avgSurvivalTime: (float) ($d['avgSurvivalTime'] ?? 0),
            top10Ratio: (float) ($d['top10Ratio'] ?? 0),
            winRatio: (float) ($d['winRatio'] ?? 0),
            assists: (int) ($d['assists'] ?? 0),
            wins: (int) ($d['wins'] ?? 0),
            kda: (float) ($d['kda'] ?? 0),
            kdr: (float) ($d['kdr'] ?? 0),
            avgKill: (float) ($d['avgKill'] ?? 0),
            kills: (int) ($d['kills'] ?? 0),
            deaths: (int) ($d['deaths'] ?? 0),
            roundMostKills: (int) ($d['roundMostKills'] ?? 0),
            longestKill: (float) ($d['longestKill'] ?? 0),
            headshotKills: (int) ($d['headshotKills'] ?? 0),
            headshotKillRatio: (float) ($d['headshotKillRatio'] ?? 0),
            damageDealt: (float) ($d['damageDealt'] ?? 0),
            dBNOs: (int) ($d['dBNOs'] ?? 0),
            reviveRatio: (float) ($d['reviveRatio'] ?? 0),
            revives: (int) ($d['revives'] ?? 0),
            heals: (int) ($d['heals'] ?? 0),
            boosts: (int) ($d['boosts'] ?? 0),
            weaponsAcquired: (int) ($d['weaponsAcquired'] ?? 0),
            teamKills: (int) ($d['teamKills'] ?? 0),
            playTime: (float) ($d['playTime'] ?? 0),
            killStreak: (int) ($d['killStreak'] ?? 0),
        );
    }
}
