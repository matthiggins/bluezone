<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Responses\PubgResponse;
use Illuminate\Support\Collection;
use Saloon\Http\BaseResource;
use Saloon\Http\Request;

abstract class Resource extends BaseResource
{
    /**
     * Send a request and return its DTO; AlwaysThrowOnErrors makes non-2xx responses throw before dto().
     */
    protected function send(Request $request): PubgResponse|Collection
    {
        return $this->connector->send($request)->dto();
    }
}
