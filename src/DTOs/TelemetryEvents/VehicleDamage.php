<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

use LaravelPubg\DTOs\Concerns\AccessesJsonDictionaries;
use LaravelPubg\DTOs\TelemetryObjects\Character;
use LaravelPubg\DTOs\TelemetryObjects\Vehicle;

class VehicleDamage extends AbstractEventDTO
{
    use AccessesJsonDictionaries;

    public string $type = 'vehicle damage';

    public string $damageCategoryName;

    public function __construct(
        readonly public int $attackId,
        readonly public Character $attacker,
        readonly public Vehicle $vehicle,
        readonly public string $damageTypeCategory,
        readonly public string $damageCauserName,
        readonly public float $damage,
        readonly public float $distance,
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
            damage: $data['damage'],
            distance: $data['distance'],
        );
    }
}
