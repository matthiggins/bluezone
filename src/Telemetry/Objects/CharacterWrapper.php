<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class CharacterWrapper
{
    public function __construct(
        public readonly Character $character,
        public readonly string $primaryWeaponFirst,
        public readonly string $primaryWeaponSecond,
        public readonly string $secondaryWeapon,
        public readonly int $spawnKitIndex,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            character: Character::make($data['character']),
            primaryWeaponFirst: $data['primaryWeaponFirst'],
            primaryWeaponSecond: $data['primaryWeaponSecond'],
            secondaryWeapon: $data['secondaryWeapon'],
            spawnKitIndex: $data['spawnKitIndex'],
        );
    }
}
