<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

use LaravelPubg\DTOs\TelemetryObjects\Character;
use LaravelPubg\DTOs\TelemetryObjects\Vehicle;

class PlayerPosition extends AbstractEventDTO
{
    public string $type = 'player position';

    public function __construct(
        readonly public Character $character,
        readonly public Vehicle|null $vehicle,
        readonly public float $elapsedTime,
        readonly public int $numAlivePlayers,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            vehicle: $data['vehicle'] ? Vehicle::fromEvent($data['vehicle']) : null,
            elapsedTime: $data['elapsedTime'],
            numAlivePlayers: $data['numAlivePlayers'],
        );
    }
}
