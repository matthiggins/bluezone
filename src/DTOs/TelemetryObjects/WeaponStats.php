<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryObjects;

class WeaponStats
{
    public function __construct(
        readonly public string $weapon,
        readonly public float $damage,
        readonly public float $dBNODamage,
        readonly public int $shots,
        readonly public int $hits,
        readonly public int $dBNOHits,
        readonly public int $holdingTime,
        readonly public array $hitDetails,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            weapon: $data['weapon'],
            damage: $data['damage'],
            dBNODamage: $data['dBNODamage'],
            shots: $data['shots'],
            hits: $data['hits'],
            dBNOHits: $data['dBNOHits'],
            holdingTime: $data['holdingTime'],
            hitDetails: array_map(fn ($hitDetail) => WeaponHitDetails::fromEvent($hitDetail), $data['hitDetails']),
        );
    }
}
