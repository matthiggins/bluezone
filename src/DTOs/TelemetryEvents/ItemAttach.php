<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Item;

class ItemAttach extends AbstractEventDTO
{
    public string $type = 'item attach';

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
