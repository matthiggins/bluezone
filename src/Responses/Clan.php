<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Http\Response;

class Clan extends PubgResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $shard,
        public readonly string $name,
        public readonly string $tag,
        public readonly int $level,
        public readonly int $memberCount,
    ) {}

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
