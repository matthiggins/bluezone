<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class WeaponHitDetails
{
    public function __construct(
        readonly public string $bodyPart,
        readonly public int $kills,
        readonly public int $dBNOs,
        readonly public int $hits,
        readonly public int $dBNOHits,
        readonly public int $damage,
        readonly public int $dBNODamage,
    ) {
    }

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
