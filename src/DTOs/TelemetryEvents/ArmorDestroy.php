<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

use LaravelPubg\DTOs\Concerns\AccessesJsonDictionaries;
use LaravelPubg\DTOs\TelemetryObjects\Character;
use LaravelPubg\DTOs\TelemetryObjects\Item;

class ArmorDestroy extends AbstractEventDTO
{
    use AccessesJsonDictionaries;

    public string $type = 'armor destroy';

    public string $damageCategoryName;

    public function __construct(
        readonly public int $attackId,
        readonly public Character $attacker,
        readonly public Character $victim,
        readonly public string $damageTypeCategory,
        readonly public string $damageReason,
        readonly public string $damageCauserName,
        readonly public Item $item,
        readonly public float $distance,
    ) {
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->damageTypeCategory);
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            attacker: Character::fromEvent($data['attacker']),
            victim: Character::fromEvent($data['victim']),
            damageTypeCategory: $data['damageTypeCategory'],
            damageReason: $data['damageReason'],
            damageCauserName: $data['damageCauserName'],
            item: Item::fromEvent($data['item']),
            distance: $data['distance'],
        );
    }
}
