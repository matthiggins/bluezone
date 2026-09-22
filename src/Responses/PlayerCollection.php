<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Illuminate\Support\Collection;
use Saloon\Http\Response;

final class PlayerCollection extends PubgResponse
{
    public function __construct(
        public readonly Collection $players,
    ) {}

    public static function make(Response $response): self
    {
        return new self(
            players: collect($response->json()['data'])->map(fn ($p) => Player::fromArray($p))
        );
    }
}
