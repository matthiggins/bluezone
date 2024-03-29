<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class SeasonStats extends PubgResponse
{
    public function __construct(
        readonly public string $seasonId,
        readonly public string $accountId,
        readonly public array $gameModeStats,
        readonly public array $matches,
        readonly public int $bestRankPoint,
    ) {
    }

    public static function make(Response $response): self
    {
        $data = $response->json()['data'];

        $matches = [
            'solo' => $data['relationships']['matchesSolo']['data'],
            'solo-fpp' => $data['relationships']['matchesSoloFPP']['data'],
            'duo' => $data['relationships']['matchesDuo']['data'],
            'duo-fpp' => $data['relationships']['matchesDuoFPP']['data'],
            'squad' => $data['relationships']['matchesSquad']['data'],
            'squad-fpp' => $data['relationships']['matchesSquadFPP']['data'],
        ];

        return new static($data['relationships']['season']['data']['id'], $data['relationships']['player']['data']['id'], $data['attributes']['gameModeStats'], $matches, $data['attributes']['bestRankPoint']);
    }

    public static function fromArray(array $data): self
    {
        $matches = [
            'solo' => $data['relationships']['matchesSolo']['data'],
            'solo-fpp' => $data['relationships']['matchesSoloFPP']['data'],
            'duo' => $data['relationships']['matchesDuo']['data'],
            'duo-fpp' => $data['relationships']['matchesDuoFPP']['data'],
            'squad' => $data['relationships']['matchesSquad']['data'],
            'squad-fpp' => $data['relationships']['matchesSquadFPP']['data'],
        ];

        return new static($data['relationships']['season']['data']['id'], $data['relationships']['player']['data']['id'], $data['attributes']['gameModeStats'], $matches, $data['attributes']['bestRankPoint']);
    }
}