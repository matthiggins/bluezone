<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryObjects;

class ItemPackage
{
    public function __construct(
        readonly public string $itemPackageId,
        readonly public Location $location,
        readonly public array $items,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            itemPackageId: $data['itemPackageId'],
            location: Location::fromEvent($data['location']),
            items: array_map(fn ($item) => Item::fromEvent($item), $data['items']),
        );
    }
}
