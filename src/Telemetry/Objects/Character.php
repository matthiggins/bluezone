<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class Character
{
    public function __construct(
        readonly public string $name,
        readonly public int $teamId,
        readonly public float $health,
        readonly public Location $location,
        readonly public int $ranking,
        readonly public string $accountId,
        readonly public bool $isInBlueZone,
        readonly public bool $isInRedZone,
        readonly public array $zone,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            name: $data['name'],
            teamId: $data['teamId'],
            health: $data['health'],
            location: Location::make($data['location']),
            ranking: $data['ranking'],
            accountId: $data['accountId'],
            isInBlueZone: $data['isInBlueZone'],
            isInRedZone: $data['isInRedZone'],
            zone: $data['zone'],
        );
    }
}
