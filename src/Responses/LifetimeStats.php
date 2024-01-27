<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class LifetimeStats extends PubgResponse
{
    public function __construct(
        readonly public string $accountId,
        readonly public array $gameModeStats,
        readonly public array $matches,
        readonly public float $bestRankPoint,
    ) {
    }

    public static function make(Response $response): self
    {
        $data = $response->json()['data'];

        $matches = [
            'solo' => $data['relationships']['matchesSolo']['data'],
            'soloFPP' => $data['relationships']['matchesSoloFPP']['data'],
            'duo' => $data['relationships']['matchesDuo']['data'],
            'duoFPP' => $data['relationships']['matchesDuoFPP']['data'],
            'squad' => $data['relationships']['matchesSquad']['data'],
            'squadFPP' => $data['relationships']['matchesSquadFPP']['data'],
        ];

        return new static($data['relationships']['player']['data']['id'], $data['attributes']['gameModeStats'], $matches, $data['attributes']['bestRankPoint']);
    }

    public static function fromArray(array $data): self
    {
        $matches = [
            'solo' => $data['relationships']['matchesSolo']['data'],
            'soloFPP' => $data['relationships']['matchesSoloFPP']['data'],
            'duo' => $data['relationships']['matchesDuo']['data'],
            'duoFPP' => $data['relationships']['matchesDuoFPP']['data'],
            'squad' => $data['relationships']['matchesSquad']['data'],
            'squadFPP' => $data['relationships']['matchesSquadFPP']['data'],
        ];

        return new static($data['relationships']['player']['data']['id'], $data['attributes']['gameModeStats'], $matches, $data['attributes']['bestRankPoint']);
    }
}
