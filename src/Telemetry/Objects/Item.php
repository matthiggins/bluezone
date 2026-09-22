<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;

final class Item
{
    use AccessesJsonDictionaries;

    public string $itemName;

    public function __construct(
        public readonly string $itemId,
        public readonly int $stackCount,
        public readonly string $category,
        public readonly string $subCategory,
        public readonly array $attachedItems,
    ) {
        $this->itemName = $this->getValueFromJsonFile('telemetry/item/itemId.json', $this->itemId);
    }

    public static function make(array $data): self
    {
        return new self(
            itemId: $data['itemId'],
            stackCount: (int) $data['stackCount'],
            category: $data['category'],
            subCategory: $data['subCategory'],
            attachedItems: $data['attachedItems'],
        );
    }
}
