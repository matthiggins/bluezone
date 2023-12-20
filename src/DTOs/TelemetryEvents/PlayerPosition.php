<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;
use Bluezone\DTOs\TelemetryObjects\Vehicle;

class PlayerPosition extends AbstractEventDTO
{
    public string $type = 'player position';

    public function __construct(
        readonly public Character $character,
        readonly public Vehicle|null $vehicle,
        readonly public float $elapsedTime,
        readonly public int $numAlivePlayers,
        readonly public Common $common,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        // dd($data);
        return new static(
            character: Character::fromEvent($data['character']),
            vehicle: $data['vehicle'] ? Vehicle::fromEvent($data['vehicle']) : null,
            elapsedTime: $data['elapsedTime'],
            numAlivePlayers: $data['numAlivePlayers'],
            common: Common::fromEvent($data['common']),
        );
    }
}
