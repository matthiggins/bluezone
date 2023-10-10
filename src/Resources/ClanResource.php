<?php

namespace Bluezone\Resources;

use Bluezone\DTOs\PubgDTO;
use Bluezone\Requests\Clans\ClanRequest;

class ClanResource extends Resource
{
    /**
     * Get a clan
     * 
     * @param string $clanId
     */
    public function find(string $shard, string $clanId): PubgDTO
    {
        return $this->send(new ClanRequest(
            shard: $shard,
            clanId: $clanId,
        ));
    }
}
