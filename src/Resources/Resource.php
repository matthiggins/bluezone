<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Responses\PubgResponse;
use Saloon\Http\BaseResource;
use Saloon\Http\Request;
use UnexpectedValueException;

abstract class Resource extends BaseResource
{
    /**
     * Send a request and return its DTO; AlwaysThrowOnErrors makes non-2xx responses throw before dto().
     *
     * @template TDto of PubgResponse
     *
     * @param  class-string<TDto>  $expects  the DTO class the request builds
     * @return TDto
     */
    protected function send(Request $request, string $expects): PubgResponse
    {
        $dto = $this->connector->send($request)->dto();

        if (! $dto instanceof $expects) {
            throw new UnexpectedValueException($request::class.' did not return '.$expects.'.');
        }

        return $dto;
    }
}
