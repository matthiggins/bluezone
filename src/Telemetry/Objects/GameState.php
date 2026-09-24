<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

final class GameState
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
        return new self(
            elapsedTime: (int) $data['elapsedTime'],
            numAliveTeams: (int) $data['numAliveTeams'],
            numJoinPlayers: (int) $data['numJoinPlayers'],
            numStartPlayers: (int) $data['numStartPlayers'],
            numAlivePlayers: (int) $data['numAlivePlayers'],
            // PUBG names the blue zone `safetyZone*`; the property keeps its shorter name.
            safeZonePosition: isset($data['safetyZonePosition']) ? Location::make($data['safetyZonePosition']) : null,
            safeZoneRadius: isset($data['safetyZoneRadius']) ? (float) $data['safetyZoneRadius'] : null,
            poisonGasWarningPosition: Location::make($data['poisonGasWarningPosition']),
            poisonGasWarningRadius: (float) $data['poisonGasWarningRadius'],
            redZonePosition: Location::make($data['redZonePosition']),
            redZoneRadius: (float) $data['redZoneRadius'],
            blackZonePosition: Location::make($data['blackZonePosition']),
            blackZoneRadius: (float) $data['blackZoneRadius'],
        );
    }
}
