<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Enums\Shard;
use Bluezone\Requests\SeasonsRequest;
use Bluezone\Responses\Seasons;

class SeasonResource extends Resource
{
    /**
     * Get all seasons for a shard
     */
    public function all(Shard|string $shard): Seasons
    {
        return $this->send(new SeasonsRequest(
            shard: Shard::resolve($shard)
        ), Seasons::class);
    }
}
