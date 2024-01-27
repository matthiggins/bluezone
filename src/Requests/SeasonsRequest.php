<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Responses\Seasons;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class SeasonsRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/seasons';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Seasons::make($response);
    }
}
