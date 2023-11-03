<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class RankedSeasonStats extends PubgDTO
{
    public function __construct(
        readonly public string $accountId,
        readonly public string $seasonId,
        readonly public array $gameModeStats
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json()['data'];

        return new static($data['relationships']['player']['data']['id'], $data['relationships']['season']['data']['id'], $data['attributes']['rankedGameModeStats']);
    }
}
