<?php

namespace Bluezone\Resources;

use Bluezone\DTOs\PubgDTO;
use Bluezone\Requests\Seasons\SeasonsRequest;

class SeasonResource extends Resource
{
    /**
     * Get all seasons for a shard
     */
    public function all(string $shard): PubgDTO
    {
        return $this->send(new SeasonsRequest(
            shard: $shard
        ));
    }
}
