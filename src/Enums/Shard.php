<?php

declare(strict_types=1);

namespace Bluezone\Enums;

/** Platform shards accepted by every PUBG API endpoint this SDK calls; legacy platform-region shards are unsupported. */
enum Shard: string
{
    case Steam = 'steam';
    case Xbox = 'xbox';
    case Psn = 'psn';
    case Kakao = 'kakao';
    case Console = 'console';
    case Tournament = 'tournament';

    public static function resolve(self|string $shard): self
    {
        return $shard instanceof self ? $shard : self::from($shard);
    }

    public function label(): string
    {
        return match ($this) {
            self::Steam => 'PC (Steam)',
            self::Kakao => 'PC (Kakao)',
            self::Xbox => 'Xbox',
            self::Psn => 'PlayStation',
            self::Console => 'Console',
            self::Tournament => 'Tournament',
        };
    }

    public function isConsole(): bool
    {
        return in_array($this, [self::Xbox, self::Psn, self::Console], true);
    }
}
