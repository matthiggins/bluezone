<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Shard;
use Bluezone\Responses\SeasonStatsCollection;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\HasConnector;

class SeasonStatsManyRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected Shard $shard,
        protected string $seasonId,
        protected GameMode $gameMode,
        protected array $accountIds,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard->value.'/seasons/'.$this->seasonId.'/gameMode/'.$this->gameMode->value.'/players';
    }

    protected function defaultQuery(): array
    {
        return [
            'filter[playerIds]' => implode(',', $this->accountIds),
        ];
    }

    public function createDtoFromResponse(Response $response): SeasonStatsCollection
    {
        return SeasonStatsCollection::make($response);
    }
}
