<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

use LaravelPubg\DTOs\TelemetryObjects\Character;
use LaravelPubg\DTOs\TelemetryObjects\Item;

class ItemDetach extends AbstractEventDTO
{
    public string $type = 'item detach';

    public function __construct(
        readonly public Character $character,
        readonly public Item $parentItem,
        readonly public Item $childItem,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            parentItem: Item::fromEvent($data['parentItem']),
            childItem: Item::fromEvent($data['childItem']),
        );
    }
}
