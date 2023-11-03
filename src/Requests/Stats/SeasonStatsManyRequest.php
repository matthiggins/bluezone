<?php

declare(strict_types=1);

namespace Bluezone\Requests\Stats;

use Bluezone\DTOs\SeasonStatsCollection;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class SeasonStatsManyRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $seasonId,
        protected string $gameMode,
        protected array $accountIds,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/seasons/'.$this->seasonId.'/gameMode/'.$this->gameMode.'/players';
    }

    protected function defaultQuery(): array
    {
        return [
            'filter[playerIds]' => implode(',', $this->accountIds),
        ];
    }

    public function createDtoFromResponse(Response $response): SeasonStatsCollection
    {
        return SeasonStatsCollection::fromResponse($response);
    }
}
