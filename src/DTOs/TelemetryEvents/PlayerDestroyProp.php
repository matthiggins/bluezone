<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\Concerns\AccessesJsonDictionaries;
use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;
use Bluezone\DTOs\TelemetryObjects\Location;
use Carbon\Carbon;

class PlayerDestroyProp extends AbstractEventDTO
{
    use AccessesJsonDictionaries;

    public string $type = 'player destroy prop';

    public function __construct(
        readonly public Character $attacker,
        readonly public string $objectType,
        readonly public Location $objectLocation,
        readonly public Common $common,
        readonly public Carbon $timestamp,
    ) {}

    public static function fromEvent(array $data): self
    {
        return new static(
            attacker: Character::fromEvent($data['attacker']),
            objectType: $data['objectType'],
            objectLocation: Location::fromEvent($data['objectLocation']),
            common: Common::fromEvent($data['common']),
            timestamp: Carbon::parse($data['_D']),
        );
    }
}
