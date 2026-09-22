<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Vehicle;

final class VehicleRide extends TelemetryEvent
{
    public string $type = 'vehicle ride';

    public function __construct(
        public readonly Character $character,
        public readonly Vehicle $vehicle,
        public readonly int $seatIndex,
        public readonly array $fellowPassengers,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            character: Character::make($data['character']),
            vehicle: Vehicle::make($data['vehicle']),
            seatIndex: $data['seatIndex'],
            fellowPassengers: array_map(fn ($passenger) => Character::make($passenger), $data['fellowPassengers']),
            common: Common::make($data['common']),
        );
    }
}
