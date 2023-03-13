<?php

namespace Bluezone\Resources;

use Bluezone\DTOs\PubgDTO;
use Bluezone\Requests\Mastery\SurvivalMasteryRequest;
use Bluezone\Requests\Mastery\WeaponMasteryRequest;

class MasteryResource extends Resource
{
    /**
     * Get all weapon mastery for a player
     */
    public function weapon(string $shard, string $accountId): PubgDTO
    {
        return $this->send(new WeaponMasteryRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }

    /**
     * Get all survival mastery for a player
     */
    public function survival(string $shard, string $accountId): PubgDTO
    {
        return $this->send(new SurvivalMasteryRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }
}
