<?php

declare(strict_types=1);

namespace Bluezone\Responses;

final class RankTier
{
    public function __construct(public readonly string $tier, public readonly string $subTier) {}

    /** @param array<string, mixed> $d */
    public static function fromArray(array $d): self
    {
        return new self((string) ($d['tier'] ?? 'Unranked'), (string) ($d['subTier'] ?? ''));
    }

    public function label(): string
    {
        return trim($this->tier.' '.$this->subTier);
    }
}
