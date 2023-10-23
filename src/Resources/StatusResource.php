<?php

namespace Bluezone\Resources;

use Bluezone\DTOs\PubgDTO;
use Bluezone\Requests\Clans\ClanRequest;
use Bluezone\Requests\Status\StatusRequest;

class StatusResource extends Resource
{
    /**
     * Get a clan
     * 
     * @param string $clanId
     */
    public function get(): PubgDTO
    {
        return $this->send(new StatusRequest());
    }
}
