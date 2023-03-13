<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryObjects;

use Bluezone\DTOs\Concerns\AccessesJsonDictionaries;

class DamageInfo
{
    use AccessesJsonDictionaries;

    public string $causer;

    public string $damageCategoryName;

    public function __construct(
        readonly public string $reason,
        readonly public string $typeCategory,
        readonly public string $causerName,
        readonly public array $additionalInfo,
        readonly public float $distance,
        readonly public bool|null $isThroughPentrableWall,
    ) {
        $this->causer = $this->getValueFromJsonFile('telemetry/damageCauserName.json', $this->causerName);
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->typeCategory);
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            reason: $data['damageReason'],
            typeCategory: $data['damageTypeCategory'],
            causerName: $data['damageCauserName'],
            additionalInfo: $data['additionalInfo'],
            distance: $data['distance'],
            isThroughPentrableWall: $data['isThroughPentrableWall'] ?? null,
        );
    }
}
