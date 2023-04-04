<?php

namespace Bluezone\Resources\Telemetry;

use Bluezone\DTOs\Concerns\HasEnvironmentInteractionEvents;
use Bluezone\DTOs\Concerns\HasPlayerEvents;
use Bluezone\DTOs\Concerns\HasPlayerInteractionEvents;
use Bluezone\DTOs\Concerns\HasWeaponEvents;
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
