<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class Clan extends PubgResponse
{
    public function __construct(
        readonly public string $id,
        readonly public string $shard,
        readonly public string $name,
        readonly public string $tag,
        readonly public int $level,
        readonly public int $memberCount,
    ) {
    }

    public static function make(string $shard, Response $response): self
    {
        return self::fromArray(
            shard: $shard, 
            data: $response->json()['data']
        );
    }

    public static function fromArray(string $shard, array $data): self
    {
        return new static(
            id: $data['id'], 
            shard: $shard,
            name: $data['attributes']['clanName'], 
            tag: $data['attributes']['clanTag'], 
            level: $data['attributes']['clanLevel'],
            memberCount: $data['attributes']['clanMemberCount'],
        );
    }
}
