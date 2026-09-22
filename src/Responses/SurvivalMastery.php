<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Http\Response;

class SurvivalMastery extends PubgResponse
{
    public function __construct(
        public readonly string $accountId,
        public readonly int $xp,
        public readonly int $level,
        public readonly string $lastMatchId,
        public readonly int $totalMatchesPlayed,
        public readonly array $stats,
    ) {}

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
