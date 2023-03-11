<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryEvents;

use PubgApi\DTOs\TelemetryObjects\Character;
use PubgApi\DTOs\TelemetryObjects\Item;

class ItemUnequip extends AbstractEventDTO
{
    public string $type = 'item unequip';

    public function __construct(
        readonly public Character $character,
        readonly public Item $item,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            item: Item::fromEvent($data['item']),
        );
    }
}
