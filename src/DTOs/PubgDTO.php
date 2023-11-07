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
     * Get the DTO as an array.
     */
    public function toArray(): array
    {
        $arr = get_object_vars($this);
        unset($arr['response']);

        return $arr;
    }

    /**
     * Get the DTO as a json string.
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
