<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryObjects;

use PubgApi\DTOs\Concerns\AccessesJsonDictionaries;

class Item
{
    use AccessesJsonDictionaries;

    public string $itemName;

    public function __construct(
        readonly public string $itemId,
        readonly public int $stackCount,
        readonly public string $category,
        readonly public string $subCategory,
        readonly public array $attachedItems,
    ) {
        $this->itemName = $this->getValueFromJsonFile('telemetry/item/itemId.json', $this->itemId);
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            itemId: $data['itemId'],
            stackCount: $data['stackCount'],
            category: $data['category'],
            subCategory: $data['subCategory'],
            attachedItems: $data['attachedItems'],
        );
    }
}
