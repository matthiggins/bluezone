<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class Location
{
    public function __construct(
        public readonly float $x,
        public readonly float $y,
        public readonly float $z,
    ) {}

    public static function make(array $data): self
    {
        return new static($data['x'], $data['y'], $data['z']);
    }
}
