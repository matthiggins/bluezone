<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

class PlayerTakeDamage extends TelemetryEvent
{
    use AccessesJsonDictionaries;

    public string $type = 'player take damage';

    public string $damageCategoryName;

    public function __construct(
        readonly public int $attackId,
        readonly public Character|null $attacker,
        readonly public Character $victim,
        readonly public string $damageTypeCategory,
        readonly public string $damageReason,
        readonly public string $damageCauserName,
        readonly public float $damage,
        readonly public bool $isThroughPenetrableWall,
        readonly public Common $common,
    ) {
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->damageTypeCategory);
    }

    public static function make(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            attacker: $data['attacker'] ? Character::make($data['attacker']) : null,
            victim: Character::make($data['victim']),
            damageTypeCategory: $data['damageTypeCategory'],
            damageReason: $data['damageReason'],
            damageCauserName: $data['damageCauserName'],
            damage: $data['damage'],
            isThroughPenetrableWall: $data['isThroughPenetrableWall'],
            common: Common::make($data['common']),
        );
    }
}
