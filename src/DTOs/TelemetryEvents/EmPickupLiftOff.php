<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;
use Illuminate\Support\Collection;

class EmPickupLiftOff extends AbstractEventDTO
{
    public string $type = 'emergency pickup lift off';

    public function __construct(
        readonly public Character $instigator,
        readonly public Collection $riders,
        readonly public Common $common,
    ) {}

    public static function fromEvent(array $data): self
    {
        return new static(
            instigator: Character::fromEvent($data['instigator']),
            riders: collect($data['riders'])->map(fn($rider) => Character::fromEvent($rider)),
            common: Common::fromEvent($data['common']),
        );
    }
}
