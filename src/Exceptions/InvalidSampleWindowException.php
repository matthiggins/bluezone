<?php

declare(strict_types=1);

namespace Bluezone\Exceptions;

use DateTimeInterface;

final class InvalidSampleWindowException extends BluezoneException
{
    private function __construct(public readonly DateTimeInterface $since, string $message)
    {
        parent::__construct($message);
    }

    public static function tooOld(DateTimeInterface $since): self
    {
        return new self($since, "Samples only reach back 14 days; got [{$since->format(DateTimeInterface::ATOM)}].");
    }

    public static function inFuture(DateTimeInterface $since): self
    {
        return new self($since, "Samples cannot start in the future; got [{$since->format(DateTimeInterface::ATOM)}].");
    }
}
