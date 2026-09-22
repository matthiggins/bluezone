<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;
use Carbon\Carbon;

/** Base class for telemetry events. Every concrete event redeclares `common` as a promoted constructor property. */
abstract class TelemetryEvent
{
    public readonly Common $common;

    public string $eventType = '';

    public ?Carbon $date = null;

    /** Never reached, but a readonly property declared here must be assignable from a constructor declared here. */
    protected function __construct(Common $common)
    {
        $this->common = $common;
    }

    /** @param  array<string, mixed>  $data  one decoded telemetry event */
    abstract public static function make(array $data): static;

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
