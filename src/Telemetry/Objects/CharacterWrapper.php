<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

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

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            primaryWeaponFirst: $data['primaryWeaponFirst'],
            primaryWeaponSecond: $data['primaryWeaponSecond'],
            secondaryWeapon: $data['secondaryWeapon'],
            spawnKitIndex: $data['spawnKitIndex'],
        );
    }
}
