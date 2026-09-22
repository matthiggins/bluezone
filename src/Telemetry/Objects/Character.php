<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class Character
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
        return new self(
            name: $data['name'],
            teamId: (int) $data['teamId'],
            health: (float) $data['health'],
            location: Location::make($data['location']),
            ranking: (int) $data['ranking'],
            accountId: $data['accountId'],
            isInBlueZone: (bool) $data['isInBlueZone'],
            isInRedZone: (bool) $data['isInRedZone'],
            zone: $data['zone'],
        );
    }
}
