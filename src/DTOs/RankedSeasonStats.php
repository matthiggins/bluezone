<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;
use Saloon\Traits\Responses\HasResponse;

class RankedSeasonStats implements WithResponse
{
    use HasResponse;

    public function __construct(
        readonly public array $gameModeStats
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json()['data'];

        return new static($data['attributes']['rankedGameModeStats']);
    }
}
