<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Vehicle;

class VehicleLeave extends TelemetryEvent
{
    public string $type = 'vehicle leave';

    public function __construct(
        public readonly Character $character,
        public readonly Vehicle $vehicle,
        public readonly float $rideDistance,
        public readonly int $seatIndex,
        public readonly float $maxSpeed,
        public readonly array $fellowPassengers,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            vehicle: Vehicle::make($data['vehicle']),
            rideDistance: $data['rideDistance'],
            seatIndex: $data['seatIndex'],
            maxSpeed: $data['maxSpeed'],
            fellowPassengers: array_map(fn ($passenger) => Character::make($passenger), $data['fellowPassengers']),
            common: Common::make($data['common']),
        );
    }
}
