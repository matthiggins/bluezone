<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\GameState;

class GameStatePeriodic extends AbstractEventDTO
{
    public string $type = 'game state periodic';

    public function __construct(
        readonly public GameState $gameState,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            gameState: GameState::fromEvent($data['gameState']),
        );
    }
}
