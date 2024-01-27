<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class Location
{
    public function __construct(
        readonly public float $x,
        readonly public float $y,
        readonly public float $z,
    ) {
    }

    public static function make(array $data): self
    {
        return new static($data['x'], $data['y'], $data['z']);
    }
}
