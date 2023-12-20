<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;
use Bluezone\DTOs\TelemetryObjects\Item;

class ItemDetach extends AbstractEventDTO
{
    public string $type = 'item detach';

    public function __construct(
        readonly public Character $character,
        readonly public Item $parentItem,
        readonly public Item $childItem,
        readonly public Common $common,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            parentItem: Item::fromEvent($data['parentItem']),
            childItem: Item::fromEvent($data['childItem']),
            common: Common::fromEvent($data['common']),
        );
    }
}
