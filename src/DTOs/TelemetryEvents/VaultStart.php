<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;

class VaultStart extends AbstractEventDTO
{
    public string $type = 'vault start';

    public function __construct(
        readonly public Character $character,
        readonly public bool $isLedgeGrab,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            isLedgeGrab: $data['isLedgeGrab'],
        );
    }
}
