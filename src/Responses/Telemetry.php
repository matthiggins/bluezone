<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Telemetry\MatchTelemetry;
use Bluezone\Telemetry\PlayerTelemetry;
use Bluezone\Telemetry\Events\EventFactory;
use Illuminate\Support\Collection;
use Saloon\Contracts\Response;

class Telemetry
{
    public function __construct(
        private Collection $telemetry,
    ) {
    }

    public static function make(Response $response): self
    {
        return new static(collect($response->json()));
    }

    /**
     * Map all of the raw telemetry events to Telemetry Event DTOs
     *
     * @return Collection<Events\TelemetryEvent>
     */
    public function events(): Collection
    {
        return $this->mapTelemetryToEvents();
    }

    /**
     * Map the raw telemetry events to Telemetry Event DTOs
     *
     * @return Collection<Events\TelemetryEvent>
     */
    protected function mapTelemetryToEvents(): Collection
    {
        return $this->telemetry->map(fn ($e) => EventFactory::make($e));
    }

    /**
     * Get all telemetry events that occur during the game
     *
     * @return Collection<Events\TelemetryEvent>
     */
    public function eventsDuringGame(): Collection
    {
        return $this->events()->filter(fn ($e) => $e->common->isGame >= 1);
    }

    /**
     * Get all telemetry events that occur during the game and exclude the given events
     *
     * @param  array  $excludedEvents
     * @return Collection<Events\TelemetryEvent>
     */
    public function excludeEvents(array $excludedEvents): Collection
    {
        return $this->events()->filter(fn ($e) => !in_array(get_class($e), $excludedEvents));
    }

    /**
     * Get the raw telemetry events from the telemetry file
     */
    public function raw(): Collection
    {
        return $this->telemetry;
    }

    /**
     * Get a Match Telemetry Resource
     *
     * @param  string  $ccountId
     */
    public function match(): MatchTelemetry
    {
        return new MatchTelemetry($this->events());
    }

    /**
     * Get a Player Telemetry Resource
     *
     * @param  string  $ccountId
     */
    public function player(string $accountId): PlayerTelemetry
    {
        return new PlayerTelemetry($accountId, $this->events());
    }
}
