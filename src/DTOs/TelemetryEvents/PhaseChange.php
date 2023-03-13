<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

class PhaseChange extends AbstractEventDTO
{
    public string $type = 'phase change';

    public function __construct(
        readonly public int $phase,
        readonly public float $elapsedTime,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            phase: $data['phase'],
            elapsedTime: $data['elapsedTime'],
        );
    }
}
