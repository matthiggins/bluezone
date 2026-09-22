<?php

declare(strict_types=1);

namespace Bluezone\Responses;

class PlayerMatchStats extends PubgResponse
{
    public function __construct(
        public readonly int $assists,
        public readonly int $boosts,
        public readonly float $damageDealt,
        public readonly int $dBNOs,
        public readonly string $deathType,
        public readonly int $headshotKills,
        public readonly int $heals,
        public readonly int $killPlace,
        public readonly int $killStreaks,
        public readonly int $kills,
        public readonly float $longestKill,
        public readonly string $name,
        public readonly string $playerId,
        public readonly int $revives,
        public readonly float $rideDistance,
        public readonly int $roadKills,
        public readonly float $swimDistance,
        public readonly int $teamKills,
        public readonly float $timeSurvived,
        public readonly int $vehicleDestroys,
        public readonly float $walkDistance,
        public readonly int $weaponsAcquired,
        public readonly int $winPlace,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new static(
            assists: (int) ($data['assists'] ?? 0),
            boosts: (int) ($data['boosts'] ?? 0),
            damageDealt: (float) ($data['damageDealt'] ?? 0),
            dBNOs: (int) ($data['DBNOs'] ?? 0),
            deathType: (string) ($data['deathType'] ?? ''),
            headshotKills: (int) ($data['headshotKills'] ?? 0),
            heals: (int) ($data['heals'] ?? 0),
            killPlace: (int) ($data['killPlace'] ?? 0),
            killStreaks: (int) ($data['killStreaks'] ?? 0),
            kills: (int) ($data['kills'] ?? 0),
            longestKill: (float) ($data['longestKill'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            playerId: (string) ($data['playerId'] ?? ''),
            revives: (int) ($data['revives'] ?? 0),
            rideDistance: (float) ($data['rideDistance'] ?? 0),
            roadKills: (int) ($data['roadKills'] ?? 0),
            swimDistance: (float) ($data['swimDistance'] ?? 0),
            teamKills: (int) ($data['teamKills'] ?? 0),
            timeSurvived: (float) ($data['timeSurvived'] ?? 0),
            vehicleDestroys: (int) ($data['vehicleDestroys'] ?? 0),
            walkDistance: (float) ($data['walkDistance'] ?? 0),
            weaponsAcquired: (int) ($data['weaponsAcquired'] ?? 0),
            winPlace: (int) ($data['winPlace'] ?? 0),
        );
    }
}
