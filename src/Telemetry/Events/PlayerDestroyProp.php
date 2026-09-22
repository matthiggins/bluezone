<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Location;
use Carbon\Carbon;

final class PlayerDestroyProp extends TelemetryEvent
{
    use AccessesJsonDictionaries;

    public string $type = 'player destroy prop';

    public function __construct(
        public readonly Character $attacker,
        public readonly string $objectType,
        public readonly Location $objectLocation,
        public readonly Common $common,
        public readonly Carbon $timestamp,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            attacker: Character::make($data['attacker']),
            objectType: $data['objectType'],
            objectLocation: Location::make($data['objectLocation']),
            common: Common::make($data['common']),
            timestamp: Carbon::parse($data['_D']),
        );
    }
}
