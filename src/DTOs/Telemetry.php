<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

use Bluezone\Resources\Telemetry\MatchTelemetry;
use Bluezone\Resources\Telemetry\PlayerTelemetry;
use Illuminate\Support\Collection;
use Saloon\Contracts\Response;

class Telemetry
{
    public function __construct(
        protected Collection $telemetry,
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        return new static(collect($response->json()));
    }

    /**
     * Map the raw telemetry events to Telemetry Event DTOs
     *
     * @return Collection<TelemetryEvents\TelemetryEvent>
     */
    protected function mapTelemetryToEvents(): Collection
    {
        return $this->telemetry->map(fn ($e) => TelemetryEvents\EventFactory::createDTO($e));
    }

    /**
     * Get all telemetry events as DTOs
     *
     * @return Collection<TelemetryEvents\TelemetryEvent>
     */
    public function events(): Collection
    {
        return $this->mapTelemetryToEvents();
    }

    /**
     * Get all telemetry events that occur during the game
     *
     * @return Collection<TelemetryEvents\TelemetryEvent>
     */
    public function eventsDuringGame(): Collection
    {
        return $this->events()->filter(fn ($e) => $e->common->isGame >= 1);
    }

    /**
     * Get all telemetry events that occur during the game and exclude the given events
     *
     * @param  array  $excludedEvents
     * @return Collection<TelemetryEvents\TelemetryEvent>
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
