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
    public function find(Shard|string $shard, string $matchId): PubgMatch
    {
        $shard = Shard::resolve($shard);

        try {
            return $this->send(new MatchRequest(shard: $shard, matchId: $matchId), PubgMatch::class);
        } catch (NotFoundException) {
            throw MatchNotFoundException::forId($shard, $matchId);
        }
    }
}
