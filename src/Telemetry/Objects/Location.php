<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class Location
{
    public function __construct(
        public readonly float $x,
        public readonly float $y,
        public readonly float $z,
    ) {}

    public static function make(array $data): self
    {
        return new self((float) $data['x'], (float) $data['y'], (float) $data['z']);
    }
}
