<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

class PlayerMakeGroggy extends TelemetryEvent
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

    public static function make(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            attacker: Character::make($data['attacker']),
            victim: Character::make($data['victim']),
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
            common: Common::make($data['common']),
        );
    }
}
