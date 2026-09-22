<?php

declare(strict_types=1);

namespace Bluezone\Responses;

class PlayerMatchStats extends PubgResponse
{
    public function __construct(
        public readonly int $assists,
        public readonly int $boosts,
        public readonly float $damageDealt,
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
        public readonly int $timeSurvived,
        public readonly int $vehicleDestroys,
        public readonly float $walkDistance,
        public readonly int $weaponsAcquired,
        public readonly int $winPlace,
    ) {}

    public static function fromArray(array $data): self
    {
        return new static(
            $data['assists'],
            $data['boosts'],
            $data['damageDealt'],
            $data['deathType'],
            $data['headshotKills'],
            $data['heals'],
            $data['killPlace'],
            $data['killStreaks'],
            $data['kills'],
            $data['longestKill'],
            $data['name'],
            $data['playerId'],
            $data['revives'],
            $data['rideDistance'],
            $data['roadKills'],
            $data['swimDistance'],
            $data['teamKills'],
            $data['timeSurvived'],
            $data['vehicleDestroys'],
            $data['walkDistance'],
            $data['weaponsAcquired'],
            $data['winPlace'],
        );
    }
}
