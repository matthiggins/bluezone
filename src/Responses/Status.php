<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class Status extends PubgResponse
{
    public function __construct(
        readonly public string $status,
    ) {
    }

    public static function make(Response $response): self
    {
        return self::fromArray([
            'status' => $response->ok() ? 'online' : 'offline'
        ]);
    }

    public static function fromArray(array $data): self
    {
        return new static(
            status: $data['status'],
        );
    }

    /**
     * Check if the API is online
     */
    public function isOnline(): bool
    {
        return $this->status === 'online';
    }
}
