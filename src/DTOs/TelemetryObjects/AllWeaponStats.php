<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryObjects;

class AllWeaponStats
{
    public function __construct(
        readonly public string $accountId,
        readonly public array $stats,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            accountId: $data['accountId'],
            stats: array_map(fn ($stat) => WeaponStats::fromEvent($stat), $data['stats']),
        );
    }
}
