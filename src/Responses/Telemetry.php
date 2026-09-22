<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Telemetry\Events\EventFactory;
use Bluezone\Telemetry\Events\TelemetryEvent;
use Bluezone\Telemetry\MatchTelemetry;
use Bluezone\Telemetry\PlayerTelemetry;
use Illuminate\Support\Collection;
use Saloon\Http\Response;

class Telemetry
{
    /** @var array<string, int> */
    private array $unmapped = [];

    private ?Collection $events = null;

    public function __construct(
        private Collection $telemetry,
    ) {}

    public static function make(Response $response): self
    {
        return self::fromJson($response->body());
    }

    public static function fromJson(string $json): self
    {
        return new self(collect(json_decode($json, true, flags: JSON_THROW_ON_ERROR)));
    }

    /**
     * Map all of the raw telemetry events to Telemetry Event DTOs, dropping any whose `_T` has no DTO.
     *
     * @return Collection<int, TelemetryEvent>
     */
    public function events(): Collection
    {
        return $this->events ??= $this->telemetry
            ->map(function (array $raw): ?TelemetryEvent {
                $event = EventFactory::make($raw);

                if ($event === null) {
                    $this->unmapped[$raw['_T'] ?? '?'] = ($this->unmapped[$raw['_T'] ?? '?'] ?? 0) + 1;
                }

                return $event;
            })
            ->filter()
            ->values();
    }

    /**
     * Count the raw events that events() dropped, keyed by `_T`.
     *
     * @return array<string, int>
     */
    public function unmappedTypes(): array
    {
        $this->events();

        return $this->unmapped;
    }

    /**
     * Get all telemetry events that occur during the game
     *
     * @return Collection<int, TelemetryEvent>
     */
    public function eventsDuringGame(): Collection
    {
        return $this->events()->filter(fn ($e) => $e->common->isGame >= 1);
    }

    /**
     * Get all telemetry events that occur during the game and exclude the given events
     *
     * @param  array<int, class-string<TelemetryEvent>>  $excludedEvents
     * @return Collection<int, TelemetryEvent>
     */
    public function excludeEvents(array $excludedEvents): Collection
    {
        return $this->events()->filter(fn ($e) => ! in_array(get_class($e), $excludedEvents));
    }

    /**
     * Get the raw telemetry events from the telemetry file
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function raw(): Collection
    {
        return $this->telemetry;
    }

    /**
     * Get a Match Telemetry Resource
     */
    public function match(): MatchTelemetry
    {
        return new MatchTelemetry($this->events());
    }

    /**
     * Get a Player Telemetry Resource
     */
    public function player(string $accountId): PlayerTelemetry
    {
        return new PlayerTelemetry($accountId, $this->events());
    }
}
