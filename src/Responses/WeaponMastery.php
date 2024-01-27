<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class WeaponMastery extends PubgResponse
{
    public function __construct(
        readonly public string $accountId,
        readonly public array $weaponSummaries,
    ) {
    }

    public static function make(Response $response): self
    {
        $data = $response->json()['data'];

        return new static($data['id'], $data['attributes']['weaponSummaries']);
    }
}
