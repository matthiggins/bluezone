<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class WeaponStats
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
        return new static(
            weapon: $data['weapon'],
            damage: $data['damage'],
            dBNODamage: $data['dBNODamage'],
            shots: $data['shots'],
            hits: $data['hits'],
            dBNOHits: $data['dBNOHits'],
            holdingTime: $data['holdingTime'],
            hitDetails: array_map(fn ($hitDetail) => WeaponHitDetails::make($hitDetail), $data['hitDetails']),
        );
    }
}
