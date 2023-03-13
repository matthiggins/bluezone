<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Item;

class ItemPickupFromLootBox extends AbstractEventDTO
{
    public string $type = 'item pickup from loot box';

    public function __construct(
        readonly public Character $character,
        readonly public Item $item,
        readonly public int $ownerTeamId,
        readonly public string $creatorAccountId,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            item: Item::fromEvent($data['item']),
            ownerTeamId: $data['ownerTeamId'],
            creatorAccountId: $data['creatorAccountId'],
        );
    }
}
