<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class Character
{
    public function __construct(
        public readonly string $name,
        public readonly int $teamId,
        public readonly float $health,
        public readonly Location $location,
        public readonly int $ranking,
        public readonly string $accountId,
        public readonly bool $isInBlueZone,
        public readonly bool $isInRedZone,
        public readonly array $zone,
    ) {}

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
