<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Vehicle;

final class VehicleLeave extends TelemetryEvent
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

    public static function make(array $data): static
    {
        return new self(
            character: Character::make($data['character']),
            vehicle: Vehicle::make($data['vehicle']),
            rideDistance: (float) $data['rideDistance'],
            seatIndex: (int) $data['seatIndex'],
            maxSpeed: (float) $data['maxSpeed'],
            fellowPassengers: array_map(fn ($passenger) => Character::make($passenger), $data['fellowPassengers']),
            common: Common::make($data['common']),
        );
    }
}
