<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class WeaponHitDetails
{
    public function __construct(
        public readonly string $bodyPart,
        public readonly int $kills,
        public readonly int $dBNOs,
        public readonly int $hits,
        public readonly int $dBNOHits,
        public readonly float $damage,
        public readonly float $dBNODamage,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            bodyPart: $data['bodyPart'],
            kills: (int) $data['kills'],
            dBNOs: (int) $data['dBNOs'],
            hits: (int) $data['hits'],
            dBNOHits: (int) $data['dBNOHits'],
            damage: (float) $data['damage'],
            dBNODamage: (float) $data['dBNODamage'],
        );
    }
}
