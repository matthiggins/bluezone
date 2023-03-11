<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

use LaravelPubg\DTOs\TelemetryObjects\Character;
use LaravelPubg\DTOs\TelemetryObjects\Item;

class ItemPickupFromCarePackage extends AbstractEventDTO
{
    public string $type = 'item pickup from care package';

    public function __construct(
        readonly public Character $character,
        readonly public Item $item,
        readonly public float $carePackageUniqueId,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            item: Item::fromEvent($data['item']),
            carePackageUniqueId: $data['carePackageUniqueId'],
        );
    }
}
