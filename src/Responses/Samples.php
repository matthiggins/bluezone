<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Enums\Shard;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Saloon\Http\Response;

/** A random sample of recent public matches on one shard; hundreds of ids per call. */
final class Samples extends PubgResponse
{
    /** @param Collection<int, string> $matchIds */
    public function __construct(
        public readonly string $id,
        public readonly Shard $shard,
        public readonly CarbonImmutable $createdAt,
        public readonly Collection $matchIds,
    ) {}

    public static function make(Response $response): self
    {
        return self::fromArray($response->json());
    }

    /** @param array<string, mixed> $body the decoded response body */
    public static function fromArray(array $body): self
    {
        $data = $body['data'];

        return new self(
            id: $data['id'],
            shard: Shard::from($data['attributes']['shardId']),
            createdAt: CarbonImmutable::parse($data['attributes']['createdAt']),
            matchIds: collect($data['relationships']['matches']['data'] ?? [])
                ->pluck('id')
                ->values(),
        );
    }
}
