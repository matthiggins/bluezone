<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;
use Carbon\Carbon;

class PhaseChange extends TelemetryEvent
{
    public string $type = 'phase change';

    public string $name;

    public function __construct(
        readonly public int $phase,
        readonly public float $elapsedTime,
        readonly public Common $common,
        readonly public Carbon|null $timestamp,
    ) {
        $this->name = $this->phaseName();
    }

    public static function make(array $data): self
    {
        return new static(
            phase: $data['phase'],
            elapsedTime: isset($data['elapsedTime']) ? (float) $data['elapsedTime'] : 0,
            common: Common::make($data['common']),
            timestamp: isset($data['timestamp']) ? Carbon::createFromTimestamp($data['timestamp']) : null,
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
