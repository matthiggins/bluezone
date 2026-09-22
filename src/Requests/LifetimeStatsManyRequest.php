<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Shard;
use Bluezone\Responses\LifetimeStatsCollection;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\HasConnector;

class LifetimeStatsManyRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected Shard $shard,
        protected GameMode $gameMode,
        protected array $playerIds,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard->value.'/seasons/lifetime/gameMode/'.$this->gameMode->value.'/players';
    }

    protected function defaultQuery(): array
    {
        return [
            'filter[playerIds]' => implode(',', $this->playerIds),
        ];
    }

    public function createDtoFromResponse(Response $response): LifetimeStatsCollection
    {
        return LifetimeStatsCollection::make($response);
    }
}
