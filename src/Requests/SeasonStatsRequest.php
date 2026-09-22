<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Enums\Shard;
use Bluezone\Responses\SeasonStats;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\HasConnector;

class SeasonStatsRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected Shard $shard,
        protected string $seasonId,
        protected string $accountId,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard->value.'/players/'.$this->accountId.'/seasons/'.$this->seasonId;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return SeasonStats::make($response);
    }
}
