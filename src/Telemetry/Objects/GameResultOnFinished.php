<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class GameResultOnFinished
{
    public function __construct(
        readonly public array $results,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            results: array_map(fn ($result) => GameResult::make($result), $data['results']),
        );
    }
}
