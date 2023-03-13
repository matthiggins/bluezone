<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Vehicle;

class VehicleRide extends AbstractEventDTO
{
    public string $type = 'vehicle ride';

    public function __construct(
        readonly public Character $character,
        readonly public Vehicle $vehicle,
        readonly public int $seatIndex,
        readonly public array $fellowPassengers,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            vehicle: Vehicle::fromEvent($data['vehicle']),
            seatIndex: $data['seatIndex'],
            fellowPassengers: array_map(fn ($passenger) => Character::fromEvent($passenger), $data['fellowPassengers']),
        );
    }
}
