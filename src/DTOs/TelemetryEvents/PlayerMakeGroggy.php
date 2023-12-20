<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\Concerns\AccessesJsonDictionaries;
use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;

class PlayerMakeGroggy extends AbstractEventDTO
{
    use AccessesJsonDictionaries;

    public string $type = 'player make groggy (knock)';

    public string $damageCategoryName;

    public function __construct(
        readonly public int $attackId,
        readonly public Character $attacker,
        readonly public Character $victim,
        readonly public string $damageReason,
        readonly public string $damageTypeCategory,
        readonly public string $damageCauserName,
        readonly public array $damageCauserAdditionalInfo,
        readonly public string $victimWeapon,
        readonly public array $victimWeaponAdditionalInfo,
        readonly public float $distance,
        readonly public bool $isAttackerInVehicle,
        readonly public int $dBNOId,
        readonly public bool $isThroughPenetrableWall,
        readonly public Common $common,
    ) {
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->damageTypeCategory);
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            attacker: Character::fromEvent($data['attacker']),
            victim: Character::fromEvent($data['victim']),
            damageReason: $data['damageReason'],
            damageTypeCategory: $data['damageTypeCategory'],
            damageCauserName: $data['damageCauserName'],
            damageCauserAdditionalInfo: $data['damageCauserAdditionalInfo'],
            victimWeapon: $data['victimWeapon'],
            victimWeaponAdditionalInfo: $data['victimWeaponAdditionalInfo'],
            distance: $data['distance'],
            isAttackerInVehicle: $data['isAttackerInVehicle'],
            dBNOId: $data['dBNOId'],
            isThroughPenetrableWall: $data['isThroughPenetrableWall'],
            common: Common::fromEvent($data['common']),
        );
    }
}
