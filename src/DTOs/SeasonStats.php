<?php

declare(strict_types=1);

namespace PubgApi\DTOs;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;
use Saloon\Traits\Responses\HasResponse;

class SeasonStats implements WithResponse
{
    use HasResponse;

    public function __construct(
        readonly public string $seasonId,
        readonly public string $accountId,
        readonly public array $gameModeStats,
        readonly public array $matches,
        readonly public int $bestRankPoint,
    ) {
    }

    public static function fromResponse(Response $response): self
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

        return new static($data['relationships']['season']['data']['id'], $data['relationships']['player']['data']['id'], $data['attributes']['gameModeStats'], $matches, $data['attributes']['bestRankPoint']);
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

        return new static($data['relationships']['season']['data']['id'], $data['relationships']['player']['data']['id'], $data['attributes']['gameModeStats'], $matches, $data['attributes']['bestRankPoint']);
    }
}
