<?php

declare(strict_types=1);

namespace Bluezone\Responses;

final class MatchRoster
{
    /** @param array<int, string> $participantIds */
    public function __construct(
        public readonly string $id,
        public readonly int $rank,
        public readonly int $teamId,
        public readonly bool $won,
        public readonly string $shardId,
        public readonly array $participantIds,
    ) {}

    /** @param array<string, mixed> $item */
    public static function fromArray(array $item): self
    {
        return new self(
            id: $item['id'],
            rank: (int) $item['attributes']['stats']['rank'],
            teamId: (int) $item['attributes']['stats']['teamId'],
            won: filter_var($item['attributes']['won'], FILTER_VALIDATE_BOOLEAN),
            shardId: (string) $item['attributes']['shardId'],
            participantIds: array_map(fn (array $p): string => $p['id'], $item['relationships']['participants']['data'] ?? []),
        );
    }
}
