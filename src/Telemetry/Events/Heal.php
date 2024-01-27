<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

class Heal extends TelemetryEvent
{
    public string $type = 'heal';

    public function __construct(
        readonly public Character $character,
        readonly public Item $item,
        readonly public float $healAmount,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            item: Item::make($data['item']),
            healAmount: isset($data['healamount']) ? $data['healamount'] : (isset($data['healAmount']) ? $data['healAmount'] : 0),
            common: Common::make($data['common']),
        );
    }
}
