<?php

namespace LaravelPubg;

use Saloon\Http\Connector;

class PubgConnector extends Connector
{
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
}
