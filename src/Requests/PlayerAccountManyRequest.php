<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Enums\Shard;
use Bluezone\Responses\PlayerCollection;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\HasConnector;

class PlayerAccountManyRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected Shard $shard,
        protected array $accountIds,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard->value.'/players';
    }

    /** @return array<string, string> */
    protected function defaultQuery(): array
    {
        return ['filter[playerIds]' => implode(',', $this->accountIds)];
    }

    /** Null when none of the ids exist on the shard; PlayerResource::findMany() turns that into a PlayerNotFoundException. */
    public function createDtoFromResponse(Response $response): ?PlayerCollection
    {
        return ($response->json()['data'] ?? []) === [] ? null : PlayerCollection::make($response);
    }
}
