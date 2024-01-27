<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\AllWeaponStats;
use Bluezone\Telemetry\Objects\CharacterWrapper;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\GameResultOnFinished;

class MatchEnd extends TelemetryEvent
{
    public string $type = 'match end';

    public function __construct(
        readonly public array $characters,
        readonly public GameResultOnFinished $gameResultOnFinished,
        readonly public array $allWeaponStats,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            characters: array_map(fn ($character) => CharacterWrapper::make($character), $data['characters']),
            gameResultOnFinished: GameResultOnFinished::make($data['gameResultOnFinished']),
            allWeaponStats: array_map(fn ($weaponStats) => AllWeaponStats::make($weaponStats), $data['allWeaponStats']),
            common: Common::make($data['common']),
        );
    }
}
