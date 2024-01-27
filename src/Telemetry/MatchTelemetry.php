<?php

namespace Bluezone\Telemetry;

use Bluezone\Telemetry\Events\CarePackageLand;
use Bluezone\Telemetry\Events\CarePackageSpawn;
use Bluezone\Telemetry\Events\GameStatePeriodic;
use Bluezone\Telemetry\Events\MatchDefinition;
use Bluezone\Telemetry\Events\MatchEnd;
use Bluezone\Telemetry\Events\MatchStart;
use Bluezone\Telemetry\Events\PhaseChange;
use Illuminate\Support\Collection;

class MatchTelemetry
{
    public function __construct(
        protected Collection $telemetry,
    ) {
    }

    /**
     * Get the match care package events
     */
    public function carePackageEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return $event instanceof CarePackageLand || $event instanceof CarePackageSpawn;
        })->values();
    }

    /**
     * Get the match definition event
     */
    public function definition(): MatchDefinition
    {
        return $this->telemetry->filter(function ($event) {
            return $event instanceof MatchDefinition;
        })->first();
    }

    /**
     * Get the match end event
     */
    public function end(): MatchEnd
    {
        return $this->telemetry->filter(function ($event) {
            return $event instanceof MatchEnd;
        })->first();
    }

    /**
     * Get the phase change event
     */
    public function phaseChanges(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return $event instanceof PhaseChange;
        })->values();
    }

    /**
     * Get the match start event
     */
    public function start(): MatchStart
    {
        return $this->telemetry->filter(function ($event) {
            return $event instanceof MatchStart;
        })->first();
    }

    /**
     * Get the match state events
     */
    public function stateEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return $event instanceof GameStatePeriodic;
        })->values();
    }
}
