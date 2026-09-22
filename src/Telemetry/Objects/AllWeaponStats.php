<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class AllWeaponStats
{
    public function __construct(
        public readonly string $accountId,
        public readonly array $stats,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            accountId: $data['accountId'],
            stats: array_map(fn ($stat) => WeaponStats::make($stat), $data['stats']),
        );
    }
}
