<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class Player extends PubgDTO
{
    public function __construct(
        readonly public string $id,
        readonly public string $name,
        readonly public string $shard,
        readonly public string|null $clanId,
        readonly public string|null $banType,
        readonly public array $matches,
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json()['data'];

        return self::fromArray($data);
    }

    public static function fromArray(array $data): self
    {
        $matches = array_map(fn ($m) => $m['id'], $data['relationships']['matches']['data']);

        return new static(
            id: $data['id'], 
            name: $data['attributes']['name'], 
            shard: $data['attributes']['shardId'], 
            clanId: $data['attributes']['clanId'] ?? null,
            banType: $data['attributes']['banType'] ?? null,
            matches: $matches
        );
    }
}
