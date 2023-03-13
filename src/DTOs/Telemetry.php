<?php

declare(strict_types=1);

namespace Bluezone\DTOs;

use Bluezone\DTOs\Concerns\HasPlayerEvents;
use Bluezone\Resources\Telemetry\MatchTelemetry;
use Bluezone\Resources\Telemetry\PlayerTelemetry;
use Illuminate\Support\Collection;
use Saloon\Contracts\Response;

class Telemetry
{
    use HasPlayerEvents;

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
     * Get the raw telemetry events from the telemetry file
     * 
     * @return Collection
     */
    public function raw(): Collection
    {
        return $this->telemetry;
    }

    /**
     * Get a Player Telemetry Resource
     * 
     * @param string $ccountId
     * @return MatchTelemetry
     */
    public function match(): MatchTelemetry
    {
        return new MatchTelemetry($this->events());
    }

    /**
     * Get a Player Telemetry Resource
     * 
     * @param string $ccountId
     * @return PlayerTelemetry
     */
    public function player(string $accountId): PlayerTelemetry
    {
        return new PlayerTelemetry($accountId, $this->events());
    }
}
