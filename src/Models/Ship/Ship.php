<?php

declare(strict_types=1);

namespace App\Models\Ship;

abstract class Ship
{
    /** @var array<\App\Models\Target> */
    protected array $targets = [];

    private int $shots = 0;

    abstract public function getName(): string;

    abstract public function getSize(): int;

    /** @return array<\App\Models\Target> */
    final public function getTargets(): array
    {
        return $this->targets;
    }

    /** @param array<\App\Models\Target> $targets */
    final public function setTargets(array $targets): void
    {
        $this->targets = $targets;
    }

    final public function getShots(): int
    {
        return $this->shots;
    }

    final public function incrementShots(): void
    {
        $this->shots += 1;
    }

    final public function isSunk(): bool
    {
        return $this->shots === count($this->targets);
    }
}
