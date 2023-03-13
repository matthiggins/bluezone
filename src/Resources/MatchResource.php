<?php

namespace Bluezone\Resources;

use Bluezone\DTOs\PubgDTO;
use Bluezone\Requests\Matches\MatchRequest;

class MatchResource extends Resource
{
    /**
     * Get a single match
     */
    public function find(string $shard, string $matchId): PubgDTO
    {
        return $this->send(new MatchRequest(
            shard: $shard,
            matchId: $matchId,
        ));
    }
}
