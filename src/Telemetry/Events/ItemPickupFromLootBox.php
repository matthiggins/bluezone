<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

final class ItemPickupFromLootBox extends TelemetryEvent
{
    public string $type = 'item pickup from loot box';

    public function __construct(
        public readonly Character $character,
        public readonly Item $item,
        public readonly int $ownerTeamId,
        public readonly string $creatorAccountId,
        public readonly Common $common,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            character: Character::make($data['character']),
            item: Item::make($data['item']),
            ownerTeamId: (int) $data['ownerTeamId'],
            creatorAccountId: $data['creatorAccountId'],
            common: Common::make($data['common']),
        );
    }
}
