<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class Stats
{
    public function __construct(
        public readonly int $killCount,
        public readonly float $distanceOnFoot,
        public readonly float $distanceOnSwim,
        public readonly float $distanceOnVehicle,
        public readonly float $distanceOnParachute,
        public readonly float $distanceOnFreefall,
    ) {}

    public static function make(array $data): self
    {
        return new self($data['killCount'], $data['distanceOnFoot'], $data['distanceOnSwim'], $data['distanceOnVehicle'], $data['distanceOnParachute'], $data['distanceOnFreefall']);
    }
}
