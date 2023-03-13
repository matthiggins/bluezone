<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class Player extends PubgDTO implements WithResponse
{
    public function __construct(
        readonly public string $id,
        readonly public string $name,
        readonly public string $shard,
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

        return new static($data['id'], $data['attributes']['name'],  $data['attributes']['shardId'], $matches);
    }
}
