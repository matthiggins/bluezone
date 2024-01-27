<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

class ItemPickupFromLootBox extends TelemetryEvent
{
    public string $type = 'item pickup from loot box';

    public function __construct(
        readonly public Character $character,
        readonly public Item $item,
        readonly public int $ownerTeamId,
        readonly public string $creatorAccountId,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            item: Item::make($data['item']),
            ownerTeamId: $data['ownerTeamId'],
            creatorAccountId: $data['creatorAccountId'],
            common: Common::make($data['common']),
        );
    }
}
