<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Vehicle;

class WheelDestroy extends TelemetryEvent
{
    use AccessesJsonDictionaries;

    public string $type = 'wheel destroy';

    public string $damageCategoryName;

    public function __construct(
        readonly public int $attackId,
        readonly public Character $attacker,
        readonly public Vehicle $vehicle,
        readonly public string $damageTypeCategory,
        readonly public string $damageCauserName,
        readonly public Common $common,
    ) {
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->damageTypeCategory);
    }

    public static function make(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            attacker: Character::make($data['attacker']),
            vehicle: Vehicle::make($data['vehicle']),
            damageTypeCategory: $data['damageTypeCategory'],
            damageCauserName: $data['damageCauserName'],
            common: Common::make($data['common']),
        );
    }
}
