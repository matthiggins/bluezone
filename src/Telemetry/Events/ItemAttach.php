<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

class ItemAttach extends TelemetryEvent
{
    public string $type = 'item attach';

    public function __construct(
        readonly public Character $character,
        readonly public Item $parentItem,
        readonly public Item $childItem,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            parentItem: Item::make($data['parentItem']),
            childItem: Item::make($data['childItem']),
            common: Common::make($data['common']),
        );
    }
}
