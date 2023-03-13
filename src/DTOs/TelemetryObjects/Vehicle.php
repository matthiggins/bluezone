<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryObjects;

use Bluezone\DTOs\Concerns\AccessesJsonDictionaries;

class Vehicle
{
    use AccessesJsonDictionaries;

    public string $vehicleName;

    public function __construct(
        readonly public string $vehicleType,
        readonly public string $vehicleId,
        readonly public int|null $vehicleUniqueId,
        readonly public float $healthPercent,
        readonly public float|null $fuelPercent,
        readonly public float $altitudeAbs,
        readonly public float $altitudeRel,
        readonly public float $velocity,
        readonly public int $seatIndex,
        readonly public bool $isWheelsInAir,
        readonly public bool $isInWaterVolume,
        readonly public bool $isEngineOn,
    ) {
        $this->vehicleName = $this->getValueFromJsonFile('telemetry/vehicle/vehicleId.json', $this->vehicleId);
    }

    public static function fromEvent(array $data): self
    {
        // dd($data)
        return new static(
            vehicleType: $data['vehicleType'],
            vehicleId: $data['vehicleId'],
            vehicleUniqueId: $data['vehicleUniqueId'] ?? null,
            healthPercent: $data['healthPercent'],
            fuelPercent: $data['fuelPercent'] ?? null,
            altitudeAbs: $data['altitudeAbs'],
            altitudeRel: $data['altitudeRel'],
            velocity: $data['velocity'],
            seatIndex: $data['seatIndex'],
            isWheelsInAir: $data['isWheelsInAir'],
            isInWaterVolume: $data['isInWaterVolume'],
            isEngineOn: $data['isEngineOn'],
        );
    }
}
