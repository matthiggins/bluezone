<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

final class ItemAttach extends TelemetryEvent
{
    public string $type = 'item attach';

    public function __construct(
        public readonly Character $character,
        public readonly Item $parentItem,
        public readonly Item $childItem,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            character: Character::make($data['character']),
            parentItem: Item::make($data['parentItem']),
            childItem: Item::make($data['childItem']),
            common: Common::make($data['common']),
        );
    }
}
