<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Support\Dictionary;

final class WeaponMedal extends PubgResponse
{
    public function __construct(
        public readonly string $medalId,
        public readonly int $count,
        public readonly string $name,
        public readonly string $description,
    ) {}

    /** @param array<string, mixed> $d */
    public static function fromArray(array $d): self
    {
        $medalId = (string) ($d['MedalId'] ?? '');
        $medal = Dictionary::load('weaponMastery/medalName.json')[$medalId] ?? ['name' => $medalId, 'description' => ''];

        return new self(
            medalId: $medalId,
            count: (int) ($d['Count'] ?? 0),
            name: (string) $medal['name'],
            description: (string) $medal['description'],
        );
    }
}
