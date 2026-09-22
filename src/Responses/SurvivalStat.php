<?php

declare(strict_types=1);

namespace Bluezone\Responses;

final class SurvivalStat extends PubgResponse
{
    public function __construct(
        public readonly string $key,
        public readonly ?float $total,
        public readonly ?float $average,
        public readonly ?float $careerBest,
        public readonly ?float $lastMatchValue,
    ) {}

    /** @param array<string, mixed> $d */
    public static function fromArray(string $key, array $d): self
    {
        return new self(
            key: $key,
            total: isset($d['total']) ? (float) $d['total'] : null,
            average: isset($d['average']) ? (float) $d['average'] : null,
            careerBest: isset($d['careerBest']) ? (float) $d['careerBest'] : null,
            lastMatchValue: isset($d['lastMatchValue']) ? (float) $d['lastMatchValue'] : null,
        );
    }
}
