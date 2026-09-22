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
        public readonly int $phase,
        public readonly float $elapsedTime,
        public readonly Common $common,
        public readonly ?Carbon $timestamp,
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

    /** Whole isGame steps are a new circle appearing; the half step after each is it shrinking. */
    public function phaseName(): string
    {
        if ($this->common->isGame < 1.0) {
            return "Phase {$this->phase} lobby";
        }

        $shrinking = fmod($this->common->isGame, 1.0) >= 0.5;

        return "Phase {$this->phase} circle ".($shrinking ? 'shrinks' : 'appears');
    }
}
