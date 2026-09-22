<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Vehicle;

final class VehicleDestroy extends TelemetryEvent
{
    use AccessesJsonDictionaries;

    public string $type = 'vehicle destroy';

    public string $damageCategoryName;

    public function __construct(
        public readonly int $attackId,
        public readonly Character $attacker,
        public readonly Vehicle $vehicle,
        public readonly string $damageTypeCategory,
        public readonly string $damageCauserName,
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
            vehicle: Vehicle::make($data['vehicle']),
            damageTypeCategory: $data['damageTypeCategory'],
            damageCauserName: $data['damageCauserName'],
            distance: $data['distance'],
            common: Common::make($data['common']),
        );
    }
}
