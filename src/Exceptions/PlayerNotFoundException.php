<?php

declare(strict_types=1);

namespace Bluezone\Exceptions;

use Bluezone\Enums\Shard;

final class PlayerNotFoundException extends BluezoneException
{
    private function __construct(
        public readonly Shard $shard,
        public readonly string $identifier,
        string $message,
    ) {
        parent::__construct($message, 404);
    }

    public static function forName(Shard $shard, string $name): self
    {
        return new self($shard, $name, "No player named [{$name}] on shard [{$shard->value}].");
    }

    public static function forAccountId(Shard $shard, string $accountId): self
    {
        return new self($shard, $accountId, "No player with account id [{$accountId}] on shard [{$shard->value}].");
    }
}
