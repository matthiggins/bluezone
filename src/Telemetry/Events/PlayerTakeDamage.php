<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class PlayerTakeDamage extends TelemetryEvent
{
    use AccessesJsonDictionaries;

    public string $type = 'player take damage';

    public string $damageCategoryName;

    public function __construct(
        public readonly int $attackId,
        public readonly ?Character $attacker,
        public readonly Character $victim,
        public readonly string $damageTypeCategory,
        public readonly string $damageReason,
        public readonly string $damageCauserName,
        public readonly float $damage,
        public readonly bool $isThroughPenetrableWall,
        public readonly Common $common,
    ) {
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->damageTypeCategory);
    }

    public static function make(array $data): static
    {
        return new self(
            attackId: (int) $data['attackId'],
            attacker: $data['attacker'] ? Character::make($data['attacker']) : null,
            victim: Character::make($data['victim']),
            damageTypeCategory: $data['damageTypeCategory'],
            damageReason: $data['damageReason'],
            damageCauserName: $data['damageCauserName'],
            damage: (float) $data['damage'],
            isThroughPenetrableWall: (bool) $data['isThroughPenetrableWall'],
            common: Common::make($data['common']),
        );
    }
}
