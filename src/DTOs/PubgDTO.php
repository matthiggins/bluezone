<?php

namespace Bluezone\DTOs;

use Saloon\Traits\Responses\HasResponse;

/**
 * Base DTO class.
 */
class PubgDTO
{
    use HasResponse;

    public function __construct(
    ) {
    }

    /**
     * Get the response as an array.
     *
     * @return array
     */
    public function responseArray(): array
    {
        return (array) $this->getResponse()->json();
    }

    /**
     * Get the response as json.
     *
     * @return string
     */
    public function responseJson(): string
    {
        return json_encode($this->responseArray());
    }

    /**
     * Get the DTO as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $arr = get_object_vars($this);
        unset($arr['response']);
        return $arr;
    }

    /**
     * Get the DTO as a json string.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

}
