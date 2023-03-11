<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

use LaravelPubg\DTOs\TelemetryObjects\Character;
use LaravelPubg\DTOs\TelemetryObjects\Location;

class ObjectInteraction extends AbstractEventDTO
{
    public string $type = 'object interaction';

    public function __construct(
        readonly public Character $character,
        readonly public string $objectType,
        readonly public Location|null $objectLocation,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            objectType: $data['objectType'],
            objectLocation: isset($data['objectLocation']) ? Location::fromEvent($data['objectLocation']) : null,
        );
    }
}
