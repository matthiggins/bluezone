<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Item;

class ItemPickupFromCustomPackage extends TelemetryEvent
{
    public string $type = 'item pickup from custom package';

    public function __construct(
        readonly public Character $character,
        readonly public Item $item,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            item: Item::make($data['item']),
        );
    }
}
