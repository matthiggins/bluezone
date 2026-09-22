<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\AllWeaponStats;
use Bluezone\Telemetry\Objects\CharacterWrapper;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\GameResultOnFinished;

final class MatchEnd extends TelemetryEvent
{
    public string $type = 'match end';

    public function __construct(
        public readonly array $characters,
        public readonly GameResultOnFinished $gameResultOnFinished,
        public readonly array $allWeaponStats,
        public readonly Common $common,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            characters: array_map(fn ($character) => CharacterWrapper::make($character), $data['characters']),
            gameResultOnFinished: GameResultOnFinished::make($data['gameResultOnFinished']),
            allWeaponStats: array_map(fn ($weaponStats) => AllWeaponStats::make($weaponStats), $data['allWeaponStats']),
            common: Common::make($data['common']),
        );
    }
}
