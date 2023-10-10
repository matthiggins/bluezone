<?php

declare(strict_types=1);

namespace Bluezone\Requests\Clans;

use Bluezone\DTOs\Clan;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class ClanRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $clanId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/clans/'.$this->clanId;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Clan::fromResponse($response);
    }
}
