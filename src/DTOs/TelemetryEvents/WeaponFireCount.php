<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;

class WeaponFireCount extends AbstractEventDTO
{
    public string $type = 'weapon fire count';

    public function __construct(
        readonly public Character $character,
        readonly public string $weaponId,
        readonly public int $fireCount,
        readonly public Common $common,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            weaponId: $data['weaponId'],
            fireCount: $data['fireCount'],
            common: Common::fromEvent($data['common']),
        );
    }
}
