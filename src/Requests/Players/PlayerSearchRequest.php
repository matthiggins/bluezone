<?php

declare(strict_types=1);

namespace LaravelPubg\Requests\Players;

use LaravelPubg\DTOs\Player;
use LaravelPubg\PubgConnector;
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

    public function resolveConnector(): PubgConnector
    {
        return new PubgConnector(config('pubg.api_key'));
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
