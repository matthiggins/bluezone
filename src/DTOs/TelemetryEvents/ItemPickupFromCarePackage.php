<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;
use Bluezone\DTOs\TelemetryObjects\Item;

class ItemPickupFromCarePackage extends AbstractEventDTO
{
    public string $type = 'item pickup from care package';

    public function __construct(
        readonly public Character $character,
        readonly public Item $item,
        readonly public float $carePackageUniqueId,
        readonly public Common $common,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            item: Item::fromEvent($data['item']),
            carePackageUniqueId: $data['carePackageUniqueId'],
            common: Common::fromEvent($data['common']),
        );
    }
}
