<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Vehicle;

class PlayerPosition extends TelemetryEvent
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

    public static function make(array $data): self
    {
        // dd($data);
        return new static(
            character: Character::make($data['character']),
            vehicle: $data['vehicle'] ? Vehicle::make($data['vehicle']) : null,
            elapsedTime: $data['elapsedTime'],
            numAlivePlayers: $data['numAlivePlayers'],
            common: Common::make($data['common']),
        );
    }
}
