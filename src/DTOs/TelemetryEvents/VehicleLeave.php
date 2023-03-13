<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Vehicle;

class VehicleLeave extends AbstractEventDTO
{
    public string $type = 'vehicle leave';

    public function __construct(
        readonly public Character $character,
        readonly public Vehicle $vehicle,
        readonly public float $rideDistance,
        readonly public int $seatIndex,
        readonly public float $maxSpeed,
        readonly public array $fellowPassengers,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            vehicle: Vehicle::fromEvent($data['vehicle']),
            rideDistance: $data['rideDistance'],
            seatIndex: $data['seatIndex'],
            maxSpeed: $data['maxSpeed'],
            fellowPassengers: array_map(fn ($passenger) => Character::fromEvent($passenger), $data['fellowPassengers']),
        );
    }
}
