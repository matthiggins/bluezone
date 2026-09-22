<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;

final class DamageInfo
{
    use AccessesJsonDictionaries;

    public string $causer;

    public string $damageCategoryName;

    public function __construct(
        public readonly string $reason,
        public readonly string $typeCategory,
        public readonly string $causerName,
        public readonly array $additionalInfo,
        public readonly float $distance,
        public readonly ?bool $isThroughPentrableWall,
    ) {
        $this->causer = $this->getValueFromJsonFile('telemetry/damageCauserName.json', $this->causerName);
        $this->damageCategoryName = $this->getValueFromJsonFile('telemetry/damageTypeCategory.json', $this->typeCategory);
    }

    public static function make(array $data): self
    {
        return new self(
            reason: $data['damageReason'],
            typeCategory: $data['damageTypeCategory'],
            causerName: $data['damageCauserName'],
            additionalInfo: $data['additionalInfo'],
            distance: $data['distance'],
            isThroughPentrableWall: $data['isThroughPentrableWall'] ?? null,
        );
    }
}
