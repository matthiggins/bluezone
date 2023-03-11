<?php

declare(strict_types=1);

namespace LaravelPubg\Requests\Matches;

use LaravelPubg\DTOs\PubgMatch;
use LaravelPubg\PubgConnector;
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

    public function resolveConnector(): PubgConnector
    {
        return new PubgConnector(config('pubg.api_key'));
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
