<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Enums\Shard;
use Bluezone\Responses\Player;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\HasConnector;

class PlayerSearchRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected Shard $shard,
        protected string $playerName,
    ) {}

    /**
     * Resolve the endpoint
     */
    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard->value.'/players?filter[playerNames]='.$this->playerName;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Player::fromArray($response->json()['data'][0]);
    }
}
