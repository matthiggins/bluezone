<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;

final class Vehicle
{
    use AccessesJsonDictionaries;

    public string $vehicleName;

    public function __construct(
        public readonly string $vehicleType,
        public readonly string $vehicleId,
        public readonly ?int $vehicleUniqueId,
        public readonly float $healthPercent,
        public readonly ?float $fuelPercent,
        public readonly float $altitudeAbs,
        public readonly float $altitudeRel,
        public readonly float $velocity,
        public readonly int $seatIndex,
        public readonly bool $isWheelsInAir,
        public readonly bool $isInWaterVolume,
        public readonly bool $isEngineOn,
    ) {
        $this->vehicleName = $this->getValueFromJsonFile('telemetry/vehicle/vehicleId.json', $this->vehicleId);
    }

    public static function make(array $data): self
    {
        return new self(
            vehicleType: $data['vehicleType'],
            vehicleId: $data['vehicleId'],
            vehicleUniqueId: isset($data['vehicleUniqueId']) ? (int) $data['vehicleUniqueId'] : null,
            healthPercent: (float) $data['healthPercent'],
            fuelPercent: isset($data['fuelPercent']) ? (float) $data['fuelPercent'] : null,
            altitudeAbs: (float) $data['altitudeAbs'],
            altitudeRel: (float) $data['altitudeRel'],
            velocity: (float) $data['velocity'],
            seatIndex: (int) $data['seatIndex'],
            isWheelsInAir: (bool) $data['isWheelsInAir'],
            isInWaterVolume: (bool) $data['isInWaterVolume'],
            isEngineOn: (bool) $data['isEngineOn'],
        );
    }
}
