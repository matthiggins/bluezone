<?php

namespace Bluezone;

use Bluezone\Resources\MasteryResource;
use Bluezone\Resources\MatchResource;
use Bluezone\Resources\PlayerResource;
use Bluezone\Resources\SeasonResource;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class PubgApi extends Connector
{
    use AlwaysThrowOnErrors;

    /**
     * Constructor
     */
    public function __construct(protected string $apiKey)
    {
        $this->withTokenAuth($this->apiKey);
    }

    /**
     * Resolve the base URL
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.pubg.com';
    }

    /**
     * Resolve the default headers
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/vnd.api+json',
        ];
    }

    /**
     * Weapon and Survival Mastery resource
     */
    public function mastery(): MasteryResource
    {
        return new MasteryResource($this);
    }

    /**
     * Match resource
     */
    public function match(): MatchResource
    {
        return new MatchResource($this);
    }

    /**
     * Player resource
     */
    public function player(): PlayerResource
    {
        return new PlayerResource($this);
    }

    /**
     * Season resource
     */
    public function season(): SeasonResource
    {
        return new SeasonResource($this);
    }
}
