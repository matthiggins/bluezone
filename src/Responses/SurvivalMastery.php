<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class SurvivalMastery extends PubgResponse
{
    public function __construct(
        readonly public string $accountId,
        readonly public int $xp,
        readonly public int $level,
        readonly public string $lastMatchId,
        readonly public int $totalMatchesPlayed,
        readonly public array $stats,
    ) {
    }

    public static function make(Response $response): self
    {
        $data = $response->json()['data'];

        return new static(
            accountId: $data['id'],
            xp: $data['attributes']['xp'],
            level: $data['attributes']['level'],
            lastMatchId: $data['attributes']['lastMatchId'],
            totalMatchesPlayed: $data['attributes']['totalMatchesPlayed'],
            stats: $data['attributes']['stats']
        );
    }
}
