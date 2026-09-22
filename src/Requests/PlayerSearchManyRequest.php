<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Enums\Shard;
use Bluezone\Responses\PlayerCollection;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\HasConnector;

class PlayerSearchManyRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected Shard $shard,
        protected array $playerNames,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard->value.'/players';
    }

    /** @return array<string, string> */
    protected function defaultQuery(): array
    {
        return ['filter[playerNames]' => implode(',', $this->playerNames)];
    }

    /** Null when none of the names exist on the shard; PlayerResource::searchMany() turns that into a PlayerNotFoundException. */
    public function createDtoFromResponse(Response $response): ?PlayerCollection
    {
        return ($response->json()['data'] ?? []) === [] ? null : PlayerCollection::make($response);
    }
}
