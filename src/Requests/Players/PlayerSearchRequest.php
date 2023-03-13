<?php

declare(strict_types=1);

namespace Bluezone\Requests\Players;

use Bluezone\DTOs\Player;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class PlayerSearchRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $playerName,
    ) {
    }

    /**
     * Resolve the endpoint
     */
    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/players?filter[playerNames]='.$this->playerName;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Player::fromArray($response->json()['data'][0]);
    }
}
