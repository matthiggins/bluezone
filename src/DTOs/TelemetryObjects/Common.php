<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryObjects;

class Common
{
    public function __construct(
        readonly public float $isGame,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static($data['isGame']);
    }

    public function phaseName(): string
    {
        return match (true) {
            $this->isGame < 0.1 => 'Before lift off',
            $this->isGame >= 0.1 && $this->isGame < 0.5 => 'On airplane',
            $this->isGame >= 0.5 && $this->isGame < 1.0 => 'Before 1st zone',
            $this->isGame >= 1.0 && $this->isGame < 1.5 => '1st zone appears',
            $this->isGame >= 1.5 && $this->isGame < 2.0 => '1st bluezone shrinks',
            $this->isGame >= 2.0 && $this->isGame < 2.5 => '2nd zone appears',
            $this->isGame >= 2.5 && $this->isGame < 3.0 => '2nd bluezone shrinks',
            $this->isGame >= 3.0 && $this->isGame < 3.5 => '3rd zone appears',
            $this->isGame >= 3.5 && $this->isGame < 4.0 => '3rd bluezone shrinks',
            $this->isGame >= 4.0 && $this->isGame < 4.5 => '4th zone appears',
            $this->isGame >= 4.5 && $this->isGame < 5.0 => '4th bluezone shrinks',
            $this->isGame >= 5.0 && $this->isGame < 5.5 => '5th zone appears',
            $this->isGame >= 5.5 && $this->isGame < 6.0 => '5th bluezone shrinks',
            $this->isGame >= 6.0 && $this->isGame < 6.5 => '6th zone appears',
            $this->isGame >= 6.5 && $this->isGame < 7.0 => '6th bluezone shrinks',
            $this->isGame >= 7.0 && $this->isGame < 7.5 => '7th zone appears',
            $this->isGame >= 7.5 && $this->isGame < 8.0 => '7th bluezone shrinks',
            $this->isGame >= 8.0 && $this->isGame < 8.5 => '8th zone appears',
            $this->isGame >= 8.5 && $this->isGame < 9.0 => '8th bluezone shrinks',
            $this->isGame >= 9.0 && $this->isGame < 9.5 => '9th zone appears',
            $this->isGame >= 9.5 && $this->isGame < 10.0 => '9th bluezone shrinks',
            default => 'Unknown phase',
        };
    }
}
