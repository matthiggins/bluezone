<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryObjects;

class GameResultOnFinished
{
    public function __construct(
        readonly public array $results,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            results: array_map(fn ($result) => GameResult::fromEvent($result), $data['results']),
        );
    }
}
