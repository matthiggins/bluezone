<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Responses\RankedSeasonStats;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class RankedSeasonStatsRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $seasonId,
        protected string $accountId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/players/'.$this->accountId.'/seasons/'.$this->seasonId.'/ranked';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return RankedSeasonStats::make($response);
    }
}
