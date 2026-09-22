<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class SpecialZone
{
    public function __construct(
        public readonly string $zoneType,
        public readonly Location $position,
        public readonly float $horizontalRadius,
        public readonly float $verticalRadius,
        public readonly int $uniqueId,
        public readonly string $zoneState,
    ) {}

    /** @param  array<string, mixed>  $data */
    public static function make(array $data): static
    {
        return new self(
            zoneType: $data['zoneType'] ?? '',
            position: Location::make($data['position']),
            horizontalRadius: (float) ($data['horizontalRadius'] ?? 0),
            verticalRadius: (float) ($data['verticalRadius'] ?? 0),
            uniqueId: (int) ($data['uniqueId'] ?? 0),
            zoneState: $data['zoneState'] ?? '',
        );
    }
}
