<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

use LaravelPubg\DTOs\TelemetryObjects\ItemPackage;

class CarePackageSpawn extends AbstractEventDTO
{
    public string $type = 'care package spawn';

    public function __construct(
        readonly public ItemPackage $itemPackage,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            itemPackage: ItemPackage::fromEvent($data['itemPackage']),
        );
    }
}
