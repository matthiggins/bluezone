<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryObjects;

class Stats
{
    public function __construct(
        readonly public int $killCount,
        readonly public float $distanceOnFoot,
        readonly public float $distanceOnSwim,
        readonly public float $distanceOnVehicle,
        readonly public float $distanceOnParachute,
        readonly public float $distanceOnFreefall,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static($data['killCount'], $data['distanceOnFoot'], $data['distanceOnSwim'], $data['distanceOnVehicle'], $data['distanceOnParachute'], $data['distanceOnFreefall']);
    }
}
