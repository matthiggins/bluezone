<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Requests\StatusRequest;
use Bluezone\Responses\PubgResponse;

class StatusResource extends Resource
{
    /**
     * Get a clan
     *
     * @param  string  $clanId
     */
    public function get(): PubgResponse
    {
        return $this->send(new StatusRequest);
    }
}
