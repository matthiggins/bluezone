<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;
use Carbon\Carbon;

/** Base class for telemetry events. Every concrete event redeclares `common` as a promoted constructor property. */
abstract class TelemetryEvent
{
    public readonly Common $common;

    public string $eventType;

    public ?Carbon $date = null;

    public function __construct(Common $common)
    {
        $this->common = $common;
    }

    public function setEventType(string $type): self
    {
        $this->eventType = $type;

        return $this;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date ? Carbon::parse($date) : null;

        return $this;
    }
}
