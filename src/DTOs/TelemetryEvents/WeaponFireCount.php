<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryEvents;

use PubgApi\DTOs\TelemetryObjects\Character;

class WeaponFireCount extends AbstractEventDTO
{
    public string $type = 'weapon fire count';

    public function __construct(
        readonly public Character $character,
        readonly public string $weaponId,
        readonly public int $fireCount,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            weaponId: $data['weaponId'],
            fireCount: $data['fireCount'],
        );
    }
}
