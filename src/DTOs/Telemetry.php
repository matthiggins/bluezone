<?php

declare(strict_types=1);

namespace PubgApi\DTOs;

use Illuminate\Support\Collection;
use PubgApi\DTOs\Concerns\HasPlayerEvents;
use Saloon\Contracts\Response;

class Telemetry
{
    use HasPlayerEvents;

    public function __construct(
        public Collection $telemetry,
    ) {
        $this->telemetry = $this->mapTelemetryToEvents();
    }

    public static function fromResponse(Response $response): self
    {
        return new static(collect($response->json()));
    }

    /**
     * @return Collection<TelemetryEvents\TelemetryEvent>
     */
    protected function mapTelemetryToEvents(): Collection
    {
        return $this->telemetry->map(fn ($e) => TelemetryEvents\EventFactory::createDTO($e));
    }

    /**
     * @return Collection<TelemetryEvents\TelemetryEvent>
     */
    public function data(): Collection
    {
        return $this->telemetry;
    }
}
