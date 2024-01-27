<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Vehicle;

class VehicleRide extends TelemetryEvent
{
    public string $type = 'vehicle ride';

    public function __construct(
        readonly public Character $character,
        readonly public Vehicle $vehicle,
        readonly public int $seatIndex,
        readonly public array $fellowPassengers,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            vehicle: Vehicle::make($data['vehicle']),
            seatIndex: $data['seatIndex'],
            fellowPassengers: array_map(fn ($passenger) => Character::make($passenger), $data['fellowPassengers']),
            common: Common::make($data['common']),
        );
    }
}
