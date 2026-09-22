<?php

declare(strict_types=1);

namespace Bluezone\Responses;

final class GameModeStats extends PubgResponse
{
    public function __construct(
        public readonly int $assists,
        public readonly int $boosts,
        public readonly int $dBNOs,
        public readonly int $dailyKills,
        public readonly int $dailyWins,
        public readonly float $damageDealt,
        public readonly int $days,
        public readonly int $headshotKills,
        public readonly int $heals,
        public readonly float $killPoints,
        public readonly int $kills,
        public readonly float $longestKill,
        public readonly float $longestTimeSurvived,
        public readonly int $losses,
        public readonly int $maxKillStreaks,
        public readonly float $mostSurvivalTime,
        public readonly float $rankPoints,
        public readonly string $rankPointsTitle,
        public readonly int $revives,
        public readonly float $rideDistance,
        public readonly int $roadKills,
        public readonly int $roundMostKills,
        public readonly int $roundsPlayed,
        public readonly int $suicides,
        public readonly float $swimDistance,
        public readonly int $teamKills,
        public readonly float $timeSurvived,
        public readonly int $top10s,
        public readonly int $vehicleDestroys,
        public readonly float $walkDistance,
        public readonly int $weaponsAcquired,
        public readonly int $weeklyKills,
        public readonly int $weeklyWins,
        public readonly float $winPoints,
        public readonly int $wins,
    ) {}

    /** @param array<string, mixed> $d */
    public static function fromArray(array $d): self
    {
        return new self(
            assists: (int) ($d['assists'] ?? 0),
            boosts: (int) ($d['boosts'] ?? 0),
            dBNOs: (int) ($d['dBNOs'] ?? 0),
            dailyKills: (int) ($d['dailyKills'] ?? 0),
            dailyWins: (int) ($d['dailyWins'] ?? 0),
            damageDealt: (float) ($d['damageDealt'] ?? 0),
            days: (int) ($d['days'] ?? 0),
            headshotKills: (int) ($d['headshotKills'] ?? 0),
            heals: (int) ($d['heals'] ?? 0),
            killPoints: (float) ($d['killPoints'] ?? 0),
            kills: (int) ($d['kills'] ?? 0),
            longestKill: (float) ($d['longestKill'] ?? 0),
            longestTimeSurvived: (float) ($d['longestTimeSurvived'] ?? 0),
            losses: (int) ($d['losses'] ?? 0),
            maxKillStreaks: (int) ($d['maxKillStreaks'] ?? 0),
            mostSurvivalTime: (float) ($d['mostSurvivalTime'] ?? 0),
            rankPoints: (float) ($d['rankPoints'] ?? 0),
            rankPointsTitle: (string) ($d['rankPointsTitle'] ?? ''),
            revives: (int) ($d['revives'] ?? 0),
            rideDistance: (float) ($d['rideDistance'] ?? 0),
            roadKills: (int) ($d['roadKills'] ?? 0),
            roundMostKills: (int) ($d['roundMostKills'] ?? 0),
            roundsPlayed: (int) ($d['roundsPlayed'] ?? 0),
            suicides: (int) ($d['suicides'] ?? 0),
            swimDistance: (float) ($d['swimDistance'] ?? 0),
            teamKills: (int) ($d['teamKills'] ?? 0),
            timeSurvived: (float) ($d['timeSurvived'] ?? 0),
            top10s: (int) ($d['top10s'] ?? 0),
            vehicleDestroys: (int) ($d['vehicleDestroys'] ?? 0),
            walkDistance: (float) ($d['walkDistance'] ?? 0),
            weaponsAcquired: (int) ($d['weaponsAcquired'] ?? 0),
            weeklyKills: (int) ($d['weeklyKills'] ?? 0),
            weeklyWins: (int) ($d['weeklyWins'] ?? 0),
            winPoints: (float) ($d['winPoints'] ?? 0),
            wins: (int) ($d['wins'] ?? 0),
        );
    }
}
