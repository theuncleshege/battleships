<?php

declare(strict_types=1);

namespace App\Data\Models\Ship;

abstract class Ship
{
    /** @var array<\App\Data\Models\Target> */
    private array $targets = [];

    abstract public function getName(): string;

    abstract public function getSize(): int;

    /** @return array<\App\Data\Models\Target> */
    final public function getTargets(): array
    {
        return $this->targets;
    }

    /** @param array<\App\Data\Models\Target> $targets */
    final public function setTargets(array $targets): void
    {
        $this->targets = $targets;
    }
}
