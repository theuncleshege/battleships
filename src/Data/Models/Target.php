<?php

declare(strict_types=1);

namespace App\Data\Models;

final class Target
{
    private string $name;
    private bool $isOccupied = false;
    private bool $isHit = false;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isOccupied(): bool
    {
        return $this->isOccupied;
    }

    public function setIsOccupied(bool $isOccupied): void
    {
        $this->isOccupied = $isOccupied;
    }

    public function isHit(): bool
    {
        return $this->isHit === true;
    }

    public function setIsHit(bool $isHit): void
    {
        $this->isHit = $isHit;
    }
}
