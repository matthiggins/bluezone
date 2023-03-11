<?php

declare(strict_types=1);

namespace PubgApi\Requests\Stats;

use PubgApi\DTOs\SeasonStats;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class MultipleSeasonStatsRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $seasonId,
        protected string $gameMode,
        protected array $playerIds,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/seasons/'.$this->seasonId.'/gameMode/'.$this->gameMode.'/players';
    }

    protected function defaultQuery(): array
    {
        return [
            'filter[playerIds]' => implode(',', $this->playerIds),
        ];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return collect($response->json()['data'])->map(fn ($player) => SeasonStats::fromArray($player));
    }
}
