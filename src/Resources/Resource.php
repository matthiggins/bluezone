<?php

namespace Bluezone\Resources;

use Bluezone\Responses\PubgResponse;
use Illuminate\Support\Collection;
use Saloon\Contracts\Connector;
use Saloon\Contracts\Request;

class Resource
{
    public function __construct(protected Connector $connector)
    {
    }

    /**
     * Send a request and return the response DTO.
     */
    public function send(Request $request): PubgResponse|Collection
    {
        $response = $this->connector->send($request);

        $response->throw();

        // If the response is a collection, map the DTOs
        return $response->dto();
    }
}
