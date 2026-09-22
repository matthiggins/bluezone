<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class GameResultOnFinished
{
    public function __construct(
        public readonly array $results,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            results: array_map(fn ($result) => GameResult::make($result), $data['results']),
        );
    }
}
