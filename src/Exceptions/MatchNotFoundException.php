<?php

declare(strict_types=1);

namespace Bluezone\Exceptions;

use Exception;
use Throwable;

class MatchNotFoundException extends Exception 
{
    public string $matchId;

    public function __construct(string $message, string $matchId)
    {
        $this->matchId = $matchId;
        $this->message = $message;

        parent::__construct($this->formatMessage(), 404);
    }

    /**
     * Format the exception message
     *
     * @return string
     */
    public function formatMessage(): string
    {
        return $this->message . ' (' . $this->matchId . ')';
    }
}
