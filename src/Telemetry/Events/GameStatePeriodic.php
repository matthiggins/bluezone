<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\GameState;

final class GameStatePeriodic extends TelemetryEvent
{
    public string $type = 'game state periodic';

    public function __construct(
        public readonly GameState $gameState,
        public readonly Common $common,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            gameState: GameState::make($data['gameState']),
            common: Common::make($data['common']),
        );
    }
}
