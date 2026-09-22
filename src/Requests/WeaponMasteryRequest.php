<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Responses\WeaponMastery;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\HasConnector;

class WeaponMasteryRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $accountId,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/players/'.$this->accountId.'/weapon_mastery';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return WeaponMastery::make($response);
    }
}
