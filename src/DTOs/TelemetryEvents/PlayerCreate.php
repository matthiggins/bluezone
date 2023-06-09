<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;

class PlayerCreate extends AbstractEventDTO
{
    public string $type = 'player create';

    public function __construct(
        readonly public Character $character,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
        );
    }
}
