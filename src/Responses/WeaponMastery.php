<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Http\Response;

class WeaponMastery extends PubgResponse
{
    public function __construct(
        public readonly string $accountId,
        public readonly array $weaponSummaries,
    ) {}

    public static function make(Response $response): self
    {
        $data = $response->json()['data'];

        return new static($data['id'], $data['attributes']['weaponSummaries']);
    }
}
