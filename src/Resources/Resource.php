<?php

namespace Bluezone\Resources;

use Bluezone\DTOs\PubgDTO;
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
     *
     * @return PubgDTO|Collection
     */
    public function send(Request $request): PubgDTO|Collection
    {
        $response = $this->connector->send($request);

        $response->throw();

        return $response->dto();
    }
}
