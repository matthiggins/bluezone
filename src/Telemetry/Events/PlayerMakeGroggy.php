<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class PlayerMakeGroggy extends TelemetryEvent
{
    use AccessesJsonDictionaries;

    public string $type = 'player make groggy (knock)';

    public string $damageCategoryName;

    public function __construct(
        public readonly int $attackId,
        public readonly Character $attacker,
        public readonly Character $victim,
        public readonly string $damageReason,
        public readonly string $damageTypeCategory,
        public readonly string $damageCauserName,
        public readonly array $damageCauserAdditionalInfo,
        public readonly string $victimWeapon,
        public readonly array $victimWeaponAdditionalInfo,
        public readonly float $distance,
        public readonly bool $isAttackerInVehicle,
        public readonly int $dBNOId,
        public readonly bool $isThroughPenetrableWall,
        public readonly Common $common,
    ) {
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->damageTypeCategory);
    }

    public static function make(array $data): static
    {
        return new self(
            attackId: (int) $data['attackId'],
            attacker: Character::make($data['attacker']),
            victim: Character::make($data['victim']),
            damageReason: $data['damageReason'],
            damageTypeCategory: $data['damageTypeCategory'],
            damageCauserName: $data['damageCauserName'],
            damageCauserAdditionalInfo: $data['damageCauserAdditionalInfo'],
            victimWeapon: $data['victimWeapon'],
            victimWeaponAdditionalInfo: $data['victimWeaponAdditionalInfo'],
            distance: (float) $data['distance'],
            isAttackerInVehicle: (bool) $data['isAttackerInVehicle'],
            dBNOId: (int) $data['dBNOId'],
            isThroughPenetrableWall: (bool) $data['isThroughPenetrableWall'],
            common: Common::make($data['common']),
        );
    }
}
