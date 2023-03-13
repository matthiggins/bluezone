<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\ItemPackage;

class CarePackageLand extends AbstractEventDTO
{
    public string $type = 'care package land';

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
