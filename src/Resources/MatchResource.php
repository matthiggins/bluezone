<?php

namespace Bluezone\Resources;

use Bluezone\Exceptions\MatchNotFoundException;
use Bluezone\Requests\MatchRequest;
use Bluezone\Responses\PubgMatch;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class MatchResource extends Resource
{
    /**
     * Get a single match
     */
    public function find(string $shard, string $matchId): PubgMatch
    {
        try {
            return $this->send(new MatchRequest(
                shard: $shard,
                matchId: $matchId,
            ));
        } catch(NotFoundException $e) {
            throw new MatchNotFoundException(
                message: 'This match is not available in the PUBG API.',
                matchId: $matchId
            );
        }
    }
}
