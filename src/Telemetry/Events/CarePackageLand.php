<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\ItemPackage;

class CarePackageLand extends TelemetryEvent
{
    public string $type = 'care package land';

    public function __construct(
        public readonly ItemPackage $itemPackage,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new static(
            itemPackage: ItemPackage::make($data['itemPackage']),
            common: Common::make($data['common']),
        );
    }
}
