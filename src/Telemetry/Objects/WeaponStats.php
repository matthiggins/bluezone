<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class WeaponStats
{
    public function __construct(
        public readonly string $weapon,
        public readonly float $damage,
        public readonly float $dBNODamage,
        public readonly int $shots,
        public readonly int $hits,
        public readonly int $dBNOHits,
        public readonly int $holdingTime,
        public readonly array $hitDetails,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            weapon: $data['weapon'],
            damage: (float) $data['damage'],
            dBNODamage: (float) $data['dBNODamage'],
            shots: (int) $data['shots'],
            hits: (int) $data['hits'],
            dBNOHits: (int) $data['dBNOHits'],
            holdingTime: (int) $data['holdingTime'],
            hitDetails: array_map(fn ($hitDetail) => WeaponHitDetails::make($hitDetail), $data['hitDetails']),
        );
    }
}
