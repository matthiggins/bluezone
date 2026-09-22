<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Exceptions\UnexpectedResponseException;
use Bluezone\Responses\PubgResponse;
use Saloon\Http\BaseResource;
use Saloon\Http\Request;

abstract class Resource extends BaseResource
{
    /**
     * @template TDto of PubgResponse
     *
     * @param  class-string<TDto>  $expects  the DTO class the request builds
     * @return TDto
     */
    protected function send(Request $request, string $expects): PubgResponse
    {
        return $this->sendNullable($request, $expects)
            ?? throw new UnexpectedResponseException($request::class.' did not return '.$expects.'.');
    }

    /**
     * Send a request whose DTO is null when the API answered with an empty `data` array.
     *
     * @template TDto of PubgResponse
     *
     * @param  class-string<TDto>  $expects  the DTO class the request builds
     * @return TDto|null
     */
    protected function sendNullable(Request $request, string $expects): ?PubgResponse
    {
        // AlwaysThrowOnErrors makes non-2xx responses throw before dto().
        $dto = $this->connector->send($request)->dto();

        if ($dto === null) {
            return null;
        }

        if (! $dto instanceof $expects) {
            throw new UnexpectedResponseException($request::class.' did not return '.$expects.'.');
        }

        return $dto;
    }
}
