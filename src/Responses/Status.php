<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Http\Response;

final class Status extends PubgResponse
{
    public function __construct(
        public readonly string $status,
        public readonly ?string $releasedAt = null,
        public readonly ?string $version = null,
    ) {}

    public static function make(Response $response): self
    {
        return new self(
            status: $response->ok() ? 'online' : 'offline',
            releasedAt: $response->json('data.attributes.releasedAt'),
            version: $response->json('data.attributes.version'),
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
