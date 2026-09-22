<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Traits\Responses\HasResponse;

class PubgResponse
{
    use HasResponse;

    public function toArray(): array
    {
        $arr = get_object_vars($this);

        unset($arr['response']);

        return $arr;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}
