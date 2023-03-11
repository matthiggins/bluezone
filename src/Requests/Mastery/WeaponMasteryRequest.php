<?php

declare(strict_types=1);

namespace LaravelPubg\Requests\Mastery;

use LaravelPubg\DTOs\WeaponMastery;
use LaravelPubg\PubgConnector;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class WeaponMasteryRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $shard,
        protected string $accountId,
    ) {
    }

    public function resolveConnector(): PubgConnector
    {
        return new PubgConnector(config('pubg.api_key'));
    }

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->shard.'/players/'.$this->accountId.'/weapon_mastery';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return WeaponMastery::fromResponse($response);
    }
}
