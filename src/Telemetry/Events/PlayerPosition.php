<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Vehicle;

final class PlayerPosition extends TelemetryEvent
{
    public string $type = 'player position';

    public function __construct(
        public readonly Character $character,
        public readonly ?Vehicle $vehicle,
        public readonly float $elapsedTime,
        public readonly int $numAlivePlayers,
        public readonly Common $common,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            character: Character::make($data['character']),
            vehicle: $data['vehicle'] ? Vehicle::make($data['vehicle']) : null,
            elapsedTime: (float) $data['elapsedTime'],
            numAlivePlayers: (int) $data['numAlivePlayers'],
            common: Common::make($data['common']),
        );
    }
}
