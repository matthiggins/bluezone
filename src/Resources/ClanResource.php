<?php

namespace Bluezone\Resources;

use Bluezone\Responses\PubgResponse;
use Bluezone\Requests\ClanRequest;
use Bluezone\Responses\Clan;

class ClanResource extends Resource
{
    /**
     * Get a clan
     * 
     * @param string $clanId
     */
    public function find(string $shard, string $clanId): Clan
    {
        return $this->send(new ClanRequest(
            shard: $shard,
            clanId: $clanId,
        ));
    }
}
