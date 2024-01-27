<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\GameState;

class GameStatePeriodic extends TelemetryEvent
{
    public string $type = 'game state periodic';

    public function __construct(
        readonly public GameState $gameState,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            gameState: GameState::make($data['gameState']),
            common: Common::make($data['common']),
        );
    }
}
