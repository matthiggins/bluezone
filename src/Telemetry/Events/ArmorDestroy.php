<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

final class ArmorDestroy extends TelemetryEvent
{
    use AccessesJsonDictionaries;

    public string $type = 'armor destroy';

    public string $damageCategoryName;

    public function __construct(
        public readonly int $attackId,
        public readonly Character $attacker,
        public readonly Character $victim,
        public readonly string $damageTypeCategory,
        public readonly string $damageReason,
        public readonly string $damageCauserName,
        public readonly Item $item,
        public readonly float $distance,
        public readonly Common $common,
    ) {
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->damageTypeCategory);
    }

    public static function make(array $data): self
    {
        return new self(
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
