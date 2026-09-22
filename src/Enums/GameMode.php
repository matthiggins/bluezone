<?php

declare(strict_types=1);

namespace Bluezone\Enums;

use Bluezone\Support\Dictionary;

enum GameMode: string
{
    case Solo = 'solo';
    case SoloFpp = 'solo-fpp';
    case Duo = 'duo';
    case DuoFpp = 'duo-fpp';
    case Squad = 'squad';
    case SquadFpp = 'squad-fpp';

    public static function resolve(self|string $mode): self
    {
        return $mode instanceof self ? $mode : self::from($mode);
    }

    /** @return array<int, self> */
    public static function battleRoyale(): array
    {
        return [self::Solo, self::SoloFpp, self::Duo, self::DuoFpp, self::Squad, self::SquadFpp];
    }

    public function label(): string
    {
        return Dictionary::get('gameMode.json', $this->value);
    }

    public function isFpp(): bool
    {
        return str_ends_with($this->value, '-fpp');
    }

    public function teamSize(): int
    {
        return match ($this) {
            self::Solo, self::SoloFpp => 1,
            self::Duo, self::DuoFpp => 2,
            self::Squad, self::SquadFpp => 4,
        };
    }
}
