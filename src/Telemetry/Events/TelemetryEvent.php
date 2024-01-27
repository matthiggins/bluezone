<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Carbon\Carbon;

class TelemetryEvent
{
    public string $eventType;
    public ?Carbon $date = null;

    public function setEventType(string $type): self
    {
        $this->eventType = $type;

        return $this;
    }

    public function setDate(string|null $date): self
    {
        $this->date = $date ? Carbon::parse($date) : null;

        return $this;
    }
}
