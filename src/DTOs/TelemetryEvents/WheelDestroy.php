<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\Concerns\AccessesJsonDictionaries;
use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;
use Bluezone\DTOs\TelemetryObjects\Vehicle;

class WheelDestroy extends AbstractEventDTO
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

    public static function fromEvent(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            attacker: Character::fromEvent($data['attacker']),
            vehicle: Vehicle::fromEvent($data['vehicle']),
            damageTypeCategory: $data['damageTypeCategory'],
            damageCauserName: $data['damageCauserName'],
            common: Common::fromEvent($data['common']),
        );
    }
}
