<?php

namespace PubgApi\Resources;

use PubgApi\Requests\Matches\MatchRequest;
use Saloon\Http\Response;

class MatchResource extends Resource
{
    /**
     * Get a single match
     */
    public function find(string $shard, string $matchId): Response
    {
        return $this->connector->send(new MatchRequest(
            shard: $shard,
            matchId: $matchId,
        ));
    }
}
