<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Enums\Shard;
use Bluezone\Exceptions\MatchNotFoundException;
use Bluezone\Requests\MatchRequest;
use Bluezone\Responses\PubgMatch;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class MatchResource extends Resource
{
    /**
     * Get a single match
     */
    public function find(Shard|string $shard, string $matchId): PubgMatch
    {
        try {
            return $this->send(new MatchRequest(
                shard: Shard::resolve($shard),
                matchId: $matchId,
            ));
        } catch (NotFoundException $e) {
            throw new MatchNotFoundException(
                message: 'This match is not available in the PUBG API.',
                matchId: $matchId
            );
        }
    }
}
