<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

class Season
{
    public function __construct(
        readonly public string $id,
        readonly public bool $isCurrentSeason,
        readonly public bool $isOffSeason,
    ) {
    }

    /**
     * Is this the current season?
     */
    public function isCurrentSeason(): bool
    {
        return $this->isCurrentSeason;
    }
}
