<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Responses\Player;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class PlayerAccountRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $accountId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/players/'.$this->accountId;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Player::make($response);
    }
}
