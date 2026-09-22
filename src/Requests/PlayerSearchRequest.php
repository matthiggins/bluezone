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

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard->value.'/players';
    }

    /** @return array<string, string> */
    protected function defaultQuery(): array
    {
        return ['filter[playerNames]' => $this->playerName];
    }

    /** Null when the shard has no player with that name; PlayerResource::search() turns that into a PlayerNotFoundException. */
    public function createDtoFromResponse(Response $response): ?Player
    {
        $data = $response->json()['data'] ?? [];

        return $data === [] ? null : Player::fromArray($data[0]);
    }
}
