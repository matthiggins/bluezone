<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;
use Bluezone\DTOs\TelemetryObjects\Item;
use Bluezone\DTOs\TelemetryObjects\Vehicle;

class ItemPickupFromVehicleTrunk extends AbstractEventDTO
{
    public string $type = 'item pickup from vehicle trunk';

    public function __construct(
        readonly public Character $character,
        readonly public Vehicle $vehicle,
        readonly public Item $item,
        readonly public Common $common,
    ) {}

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            vehicle: Vehicle::fromEvent($data['vehicle']),
            item: Item::fromEvent($data['item']),
            common: Common::fromEvent($data['common']),
        );
    }
}
