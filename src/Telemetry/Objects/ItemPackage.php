<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class ItemPackage
{
    public function __construct(
        public readonly string $itemPackageId,
        public readonly Location $location,
        public readonly array $items,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            itemPackageId: $data['itemPackageId'],
            location: Location::make($data['location']),
            items: array_map(fn ($item) => Item::make($item), $data['items']),
        );
    }
}
