<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class Clan extends PubgDTO
{
    public function __construct(
        readonly public string $id,
        readonly public string $name,
        readonly public string $tag,
        readonly public int $level,
        readonly public int $memberCount,
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json()['data'];

        return self::fromArray($data);
    }

    public static function fromArray(array $data): self
    {
        return new static(
            id: $data['id'], 
            name: $data['attributes']['clanName'], 
            tag: $data['attributes']['clanTag'], 
            level: $data['attributes']['clanLevel'],
            memberCount: $data['attributes']['clanMemberCount'],
        );
    }
}
