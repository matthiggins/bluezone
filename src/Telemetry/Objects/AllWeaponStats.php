<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class AllWeaponStats
{
    public function __construct(
        readonly public string $accountId,
        readonly public array $stats,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            accountId: $data['accountId'],
            stats: array_map(fn ($stat) => WeaponStats::make($stat), $data['stats']),
        );
    }
}
