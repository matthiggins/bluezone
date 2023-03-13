<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class WeaponMastery extends PubgDTO implements WithResponse
{
    public function __construct(
        readonly public string $accountId,
        readonly public array $weaponSummaries,
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json()['data'];

        return new static($data['id'], $data['attributes']['weaponSummaries']);
    }
}
