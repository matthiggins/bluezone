<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;

class ParachuteLanding extends AbstractEventDTO
{
    public string $type = 'parachute landing';

    public function __construct(
        readonly public Character $character,
        readonly public float $distance,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            distance: $data['distance'],
        );
    }
}
