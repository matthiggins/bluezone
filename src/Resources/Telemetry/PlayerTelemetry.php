<?php

namespace Bluezone\Resources\Telemetry;

use Bluezone\DTOs\Concerns\HasPlayerEvents;
use Illuminate\Support\Collection;

class PlayerTelemetry
{
    use HasPlayerEvents;

    public function __construct(
        protected string $accountId,
        protected Collection $telemetry,
    ) {
    }
}
