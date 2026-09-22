<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Requests\ClanRequest;
use Bluezone\Responses\Clan;

class ClanResource extends Resource
{
    /**
     * Get a clan
     */
    public function find(string $shard, string $clanId): Clan
    {
        return $this->send(new ClanRequest(
            shard: $shard,
            clanId: $clanId,
        ));
    }
}
