<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Enums\Shard;
use Bluezone\Responses\Samples;
use Carbon\Carbon;
use DateTimeInterface;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\HasConnector;

class SamplesRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected Shard $shard,
        protected ?DateTimeInterface $since = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard->value.'/samples';
    }

    /** @return array<string, string> */
    protected function defaultQuery(): array
    {
        return $this->since === null
            ? []
            : ['filter[createdAt-start]' => Carbon::instance($this->since)->utc()->format('Y-m-d\TH:i:s\Z')];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Samples::make($response);
    }
}
