<?php

namespace Bluezone\Telemetry;

use Bluezone\Telemetry\Concerns\HasEnvironmentInteractionEvents;
use Bluezone\Telemetry\Concerns\HasPlayerEvents;
use Bluezone\Telemetry\Concerns\HasPlayerInteractionEvents;
use Bluezone\Telemetry\Concerns\HasWeaponEvents;
use Illuminate\Support\Collection;

class PlayerTelemetry
{
    use HasPlayerEvents;
    use HasPlayerInteractionEvents;
    use HasEnvironmentInteractionEvents;
    use HasWeaponEvents;

    public function __construct(
        protected string $accountId,
        protected Collection $telemetry,
    ) {
    }
}
