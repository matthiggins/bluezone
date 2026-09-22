<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

final class ItemPickupFromCarePackage extends TelemetryEvent
{
    public string $type = 'item pickup from care package';

    public function __construct(
        public readonly Character $character,
        public readonly Item $item,
        public readonly float $carePackageUniqueId,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            character: Character::make($data['character']),
            item: Item::make($data['item']),
            carePackageUniqueId: $data['carePackageUniqueId'],
            common: Common::make($data['common']),
        );
    }
}
