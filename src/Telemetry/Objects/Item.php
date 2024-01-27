<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;

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

    public static function make(array $data): self
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
