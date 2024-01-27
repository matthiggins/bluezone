<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\ItemPackage;

class CarePackageSpawn extends TelemetryEvent
{
    public string $type = 'care package spawn';

    public function __construct(
        readonly public ItemPackage $itemPackage,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            itemPackage: ItemPackage::make($data['itemPackage']),
            common: Common::make($data['common']),
        );
    }
}
