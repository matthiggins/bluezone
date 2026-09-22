<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Requests\StatusRequest;
use Bluezone\Responses\Status;

class StatusResource extends Resource
{
    /**
     * Get the current status of the PUBG API
     */
    public function get(): Status
    {
        return $this->send(new StatusRequest, Status::class);
    }
}
