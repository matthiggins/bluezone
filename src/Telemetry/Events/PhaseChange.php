<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;
use Carbon\Carbon;

final class PhaseChange extends TelemetryEvent
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

    public static function make(array $data): static
    {
        return new self(
            phase: (int) $data['phase'],
            elapsedTime: isset($data['elapsedTime']) ? (float) $data['elapsedTime'] : 0,
            common: Common::make($data['common']),
            timestamp: isset($data['timestamp']) ? Carbon::createFromTimestamp($data['timestamp']) : null,
        );
    }

    /**
     * Whole isGame steps are a new circle appearing; the half step after each is it
     * shrinking. `phase` ticks up at the shrink, so the circle's number comes from isGame.
     */
    public function phaseName(): string
    {
        if ($this->common->isGame < 1.0) {
            return 'Lobby';
        }

        $circle = (int) floor($this->common->isGame);
        $shrinking = fmod($this->common->isGame, 1.0) >= 0.5;

        return "Circle {$circle} ".($shrinking ? 'shrinks' : 'appears');
    }
}
