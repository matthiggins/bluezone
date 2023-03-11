<?php

declare(strict_types=1);

namespace PubgApi\Requests\Matches;

use PubgApi\DTOs\PubgMatch;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class MatchRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $matchId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/matches/'.$this->matchId;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return PubgMatch::fromResponse($response);
    }
}
