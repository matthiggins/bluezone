<?php

namespace Bluezone\Resources;

use Bluezone\Responses\PubgResponse;
use Bluezone\Requests\SeasonsRequest;

class SeasonResource extends Resource
{
    /**
     * Get all seasons for a shard
     */
    public function all(string $shard): PubgResponse
    {
        return $this->send(new SeasonsRequest(
            shard: $shard
        ));
    }
}
