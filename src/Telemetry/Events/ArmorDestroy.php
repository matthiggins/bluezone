<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

class ArmorDestroy extends TelemetryEvent
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
        readonly public Common $common,
    ) {
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->damageTypeCategory);
    }

    public static function make(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            attacker: Character::make($data['attacker']),
            victim: Character::make($data['victim']),
            damageTypeCategory: $data['damageTypeCategory'],
            damageReason: $data['damageReason'],
            damageCauserName: $data['damageCauserName'],
            item: Item::make($data['item']),
            distance: $data['distance'],
            common: Common::make($data['common']),
        );
    }
}
