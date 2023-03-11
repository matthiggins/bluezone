<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryObjects;

class CharacterWrapper
{
    public function __construct(
        readonly public Character $character,
        readonly public string $primaryWeaponFirst,
        readonly public string $primaryWeaponSecond,
        readonly public string $secondaryWeapon,
        readonly public int $spawnKitIndex,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            primaryWeaponFirst: $data['primaryWeaponFirst'],
            primaryWeaponSecond: $data['primaryWeaponSecond'],
            secondaryWeapon: $data['secondaryWeapon'],
            spawnKitIndex: $data['spawnKitIndex'],
        );
    }
}
