<?php

namespace Bluezone\Resources;

use Bluezone\Responses\PubgResponse;
use Bluezone\Requests\ClanRequest;
use Bluezone\Requests\StatusRequest;

class StatusResource extends Resource
{
    /**
     * Get a clan
     * 
     * @param string $clanId
     */
    public function get(): PubgResponse
    {
        return $this->send(new StatusRequest());
    }
}
