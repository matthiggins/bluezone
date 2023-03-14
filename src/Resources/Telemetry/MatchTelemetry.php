<?php

namespace Bluezone\Resources\Telemetry;

use Bluezone\DTOs\TelemetryEvents\CarePackageLand;
use Bluezone\DTOs\TelemetryEvents\CarePackageSpawn;
use Bluezone\DTOs\TelemetryEvents\GameStatePeriodic;
use Bluezone\DTOs\TelemetryEvents\MatchDefinition;
use Bluezone\DTOs\TelemetryEvents\MatchEnd;
use Bluezone\DTOs\TelemetryEvents\MatchStart;
use Bluezone\DTOs\TelemetryEvents\PhaseChange;
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
        });
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
