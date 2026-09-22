<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\DamageInfo;
use Bluezone\Telemetry\Objects\GameResult;

final class PlayerKillV2 extends TelemetryEvent
{
    public string $type = 'player kill';

    public function __construct(
        public readonly int $attackId,
        public readonly int $dBNOId,
        public readonly GameResult $victimGameResult,
        public readonly Character $victim,
        public readonly string $victimWeapon,
        public readonly array $victimWeaponAdditionalInfo,
        public readonly ?Character $dBNOMaker,
        public readonly ?DamageInfo $dBNODamageInfo,
        public readonly ?Character $finisher,
        public readonly DamageInfo $finishDamageInfo,
        public readonly ?Character $killer,
        public readonly DamageInfo $killerDamageInfo,
        public readonly array $assists_AccountId,
        public readonly array $teamKillers_AccountId,
        public readonly bool $isSuicide,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            attackId: $data['attackId'],
            dBNOId: $data['dBNOId'],
            victimGameResult: GameResult::make($data['victimGameResult']),
            victim: Character::make($data['victim']),
            victimWeapon: $data['victimWeapon'],
            victimWeaponAdditionalInfo: $data['victimWeaponAdditionalInfo'],
            dBNOMaker: isset($data['DBNOMaker']) ? Character::make($data['DBNOMaker']) : null,
            dBNODamageInfo: isset($data['DBNODamageInfo']) ? DamageInfo::make($data['DBNODamageInfo']) : null,
            finisher: isset($data['finisher']) ? Character::make($data['finisher']) : null,
            finishDamageInfo: DamageInfo::make($data['finishDamageInfo']),
            killer: isset($data['killer']) ? Character::make($data['killer']) : null,
            killerDamageInfo: DamageInfo::make($data['killerDamageInfo']),
            assists_AccountId: $data['assists_AccountId'],
            teamKillers_AccountId: $data['teamKillers_AccountId'],
            isSuicide: $data['isSuicide'],
            common: Common::make($data['common']),
        );
    }
}
