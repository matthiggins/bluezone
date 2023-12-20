<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\Concerns\AccessesJsonDictionaries;
use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;

class PlayerTakeDamage extends AbstractEventDTO
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

    public static function fromEvent(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            attacker: $data['attacker'] ? Character::fromEvent($data['attacker']) : null,
            victim: Character::fromEvent($data['victim']),
            damageTypeCategory: $data['damageTypeCategory'],
            damageReason: $data['damageReason'],
            damageCauserName: $data['damageCauserName'],
            damage: $data['damage'],
            isThroughPenetrableWall: $data['isThroughPenetrableWall'],
            common: Common::fromEvent($data['common']),
        );
    }
}
