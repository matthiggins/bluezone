<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;
use Bluezone\Telemetry\Objects\Vehicle;

class ItemPutToVehicleTrunk extends TelemetryEvent
{
    public string $type = 'item put into vehicle trunk';

    public function __construct(
        readonly public Character $character,
        readonly public Vehicle $vehicle,
        readonly public Item $item,
        readonly public Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            vehicle: Vehicle::make($data['vehicle']),
            item: Item::make($data['item']),
            common: Common::make($data['common']),
        );
    }
}
