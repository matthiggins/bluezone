<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Common;
use Carbon\Carbon;

class PhaseChange extends AbstractEventDTO
{
    public string $type = 'phase change';
    public string $name;

    public function __construct(
        readonly public int $phase,
        readonly public float $elapsedTime,
        readonly public Common $common,
        readonly public Carbon $timestamp,
    ) {
        $this->name = $this->phaseName();
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            phase: $data['phase'],
            elapsedTime: $data['elapsedTime'],
            common: Common::fromEvent($data['common']),
            timestamp: Carbon::createFromTimestamp($data['timestamp'] / 1000),
        );
    }

    /**
     * Generate a phase name based on the common is game value and the phase number
     */
    public function phaseName(): string
    {
        return 'Phase '.$this->phase.' circle '.($this->phase / $this->common->isGame === 1.0 ? 'appears' : 'shrinks');
    }
}
