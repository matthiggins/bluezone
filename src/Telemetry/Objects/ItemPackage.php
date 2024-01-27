<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class ItemPackage
{
    public function __construct(
        readonly public string $itemPackageId,
        readonly public Location $location,
        readonly public array $items,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            itemPackageId: $data['itemPackageId'],
            location: Location::make($data['location']),
            items: array_map(fn ($item) => Item::make($item), $data['items']),
        );
    }
}
