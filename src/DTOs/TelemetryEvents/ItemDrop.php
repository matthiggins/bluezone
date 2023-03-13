<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Item;

class ItemDrop extends AbstractEventDTO
{
    public string $type = 'item drop';

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
