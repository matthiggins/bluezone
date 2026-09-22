<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Requests\SeasonsRequest;
use Bluezone\Responses\PubgResponse;

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
