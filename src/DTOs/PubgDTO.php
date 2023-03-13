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

    public function json(): array
    {
        return (array) $this->getResponse()->json();
    }
}
