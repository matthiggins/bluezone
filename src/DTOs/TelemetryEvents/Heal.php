<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

use LaravelPubg\DTOs\TelemetryObjects\Character;
use LaravelPubg\DTOs\TelemetryObjects\Item;

class Heal extends AbstractEventDTO
{
    public string $type = 'heal';

    public function __construct(
        readonly public Character $character,
        readonly public Item $item,
        readonly public float $healAmount,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            item: Item::fromEvent($data['item']),
            healAmount: isset($data['healamount']) ? $data['healamount'] : (isset($data['healAmount']) ? $data['healAmount'] : 0),
        );
    }
}
