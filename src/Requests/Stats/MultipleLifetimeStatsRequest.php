<?php

declare(strict_types=1);

namespace LaravelPubg\Requests\Stats;

use LaravelPubg\DTOs\LifetimeStats;
use LaravelPubg\PubgConnector;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class MultipleLifetimeStatsRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $gameMode,
        protected array $playerIds,
    ) {
    }

    public function resolveConnector(): PubgConnector
    {
        return new PubgConnector(config('pubg.api_key'));
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/seasons/lifetime/gameMode/'.$this->gameMode.'/players';
    }

    protected function defaultQuery(): array
    {
        return [
            'filter[playerIds]' => implode(',', $this->playerIds),
        ];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return collect($response->json()['data'])->map(fn ($player) => LifetimeStats::fromArray($player));
    }
}
