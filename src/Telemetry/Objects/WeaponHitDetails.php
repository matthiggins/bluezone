<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class WeaponHitDetails
{
    public function __construct(
        public readonly string $bodyPart,
        public readonly int $kills,
        public readonly int $dBNOs,
        public readonly int $hits,
        public readonly int $dBNOHits,
        public readonly int $damage,
        public readonly int $dBNODamage,
    ) {}

    public static function make(array $data): self
    {
        return new static(
            bodyPart: $data['bodyPart'],
            kills: $data['kills'],
            dBNOs: $data['dBNOs'],
            hits: $data['hits'],
            dBNOHits: $data['dBNOHits'],
            damage: $data['damage'],
            dBNODamage: $data['dBNODamage'],
        );
    }
}
