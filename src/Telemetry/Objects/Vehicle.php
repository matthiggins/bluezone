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
        // dd($data)
        return new self(
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
