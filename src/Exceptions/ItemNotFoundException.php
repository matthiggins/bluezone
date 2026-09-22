<?php

declare(strict_types=1);

namespace Bluezone\Exceptions;

use Exception;

class ItemNotFoundException extends Exception
{
    public string $itemId;

    public function __construct(string $message, string $itemId)
    {
        $this->itemId = $itemId;
        $this->message = $message;

        parent::__construct($this->formatMessage(), 404);
    }

    /**
     * Format the exception message
     */
    public function formatMessage(): string
    {
        return $this->message.' ('.$this->itemId.')';
    }
}
