<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Enums\Shard;
use Bluezone\Requests\ClanRequest;
use Bluezone\Responses\Clan;

class ClanResource extends Resource
{
    public function find(Shard|string $shard, string $clanId): Clan
    {
        return $this->send(new ClanRequest(
            shard: Shard::resolve($shard),
            clanId: $clanId,
        ), Clan::class);
    }
}
