<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

use Illuminate\Support\Collection;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class PlayerCollection extends PubgDTO implements WithResponse
{
    public function __construct(
        readonly public Collection $players,
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        return new static(
            players: collect($response->json()['data'])->map(fn ($p) => Player::fromArray($p))
        );
    }
}
