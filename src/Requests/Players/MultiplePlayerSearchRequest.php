<?php

declare(strict_types=1);

namespace PubgApi\Requests\Players;

use PubgApi\DTOs\Player;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class MultiplePlayerSearchRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected array $playerNames,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/players?filter[playerNames]='.implode(',', $this->playerNames);
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return collect($response->json()['data'])->map(fn ($player) => Player::fromArray($player));
    }
}
