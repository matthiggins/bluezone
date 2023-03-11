<?php

declare(strict_types=1);

namespace PubgApi\DTOs;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;
use Saloon\Traits\Responses\HasResponse;

class WeaponMastery implements WithResponse
{
    use HasResponse;

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
