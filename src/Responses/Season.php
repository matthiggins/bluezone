<?php

declare(strict_types=1);

namespace Bluezone\Responses;

class Season
{
    public function __construct(
        public readonly string $id,
        public readonly bool $isCurrentSeason,
        public readonly bool $isOffSeason,
    ) {}

    /**
     * Is this the current season?
     */
    public function isCurrentSeason(): bool
    {
        return $this->isCurrentSeason;
    }
}
