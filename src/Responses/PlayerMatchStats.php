<?php

declare(strict_types=1);

namespace Bluezone\Responses;

class PlayerMatchStats extends PubgResponse
{
    public function __construct(
        readonly public int $assists,
        readonly public int $boosts,
        readonly public float $damageDealt,
        readonly public string $deathType,
        readonly public int $headshotKills,
        readonly public int $heals,
        readonly public int $killPlace,
        readonly public int $killStreaks,
        readonly public int $kills,
        readonly public float $longestKill,
        readonly public string $name,
        readonly public string $playerId,
        readonly public int $revives,
        readonly public float $rideDistance,
        readonly public int $roadKills,
        readonly public float $swimDistance,
        readonly public int $teamKills,
        readonly public int $timeSurvived,
        readonly public int $vehicleDestroys,
        readonly public float $walkDistance,
        readonly public int $weaponsAcquired,
        readonly public int $winPlace,
    ) {
    }

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
