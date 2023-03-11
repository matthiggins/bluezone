<?php

declare(strict_types=1);

namespace LaravelPubg\Requests\Seasons;

use LaravelPubg\DTOs\Seasons;
use LaravelPubg\PubgConnector;
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

    public function resolveConnector(): PubgConnector
    {
        return new PubgConnector(config('pubg.api_key'));
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/seasons';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Seasons::fromResponse($response);
    }
}
