<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryEvents;

use PubgApi\DTOs\TelemetryObjects\Character;

class SwimEnd extends AbstractEventDTO
{
    public string $type = 'swim end';

    public function __construct(
        readonly public Character $character,
        readonly public float $swimDistance,
        readonly public float $maxSwimDepthOfWater,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            swimDistance: $data['swimDistance'],
            maxSwimDepthOfWater: $data['maxSwimDepthOfWater'],
        );
    }
}
