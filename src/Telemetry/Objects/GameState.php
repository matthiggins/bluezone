<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class GameState
{
    public function __construct(
        public readonly int $elapsedTime,
        public readonly int $numAliveTeams,
        public readonly int $numJoinPlayers,
        public readonly int $numStartPlayers,
        public readonly int $numAlivePlayers,
        public readonly ?Location $safeZonePosition,
        public readonly ?float $safeZoneRadius,
        public readonly Location $poisonGasWarningPosition,
        public readonly float $poisonGasWarningRadius,
        public readonly Location $redZonePosition,
        public readonly float $redZoneRadius,
        public readonly Location $blackZonePosition,
        public readonly float $blackZoneRadius,

    ) {}

    public static function make(array $data): self
    {
        return new static(
            elapsedTime: $data['elapsedTime'],
            numAliveTeams: $data['numAliveTeams'],
            numJoinPlayers: $data['numJoinPlayers'],
            numStartPlayers: $data['numStartPlayers'],
            numAlivePlayers: $data['numAlivePlayers'],
            safeZonePosition: isset($data['safeZonePosition']) ? Location::make($data['safeZonePosition']) : null,
            safeZoneRadius: $data['safeZoneRadius'] ?? null,
            poisonGasWarningPosition: Location::make($data['poisonGasWarningPosition']),
            poisonGasWarningRadius: $data['poisonGasWarningRadius'],
            redZonePosition: Location::make($data['redZonePosition']),
            redZoneRadius: $data['redZoneRadius'],
            blackZonePosition: Location::make($data['blackZonePosition']),
            blackZoneRadius: $data['blackZoneRadius'],
        );
    }
}
