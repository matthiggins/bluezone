<?php

namespace Bluezone\Resources;

use Bluezone\Requests\Seasons\SeasonsRequest;
use Saloon\Http\Response;

class SeasonResource extends Resource
{
    /**
     * Get all seasons for a shard
     */
    public function all(string $shard): Response
    {
        return $this->connector->send(new SeasonsRequest(
            shard: $shard
        ));
    }
}
