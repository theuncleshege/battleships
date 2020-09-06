<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Ship\Ship;

final class Target
{
    private string $name;
    private bool $isOccupied = false;
    private bool $isHit = false;
    private Ship $ship;

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

    public function setIsOccupied(): void
    {
        $this->isOccupied = true;
    }

    public function isHit(): bool
    {
        return $this->isHit === true;
    }

    public function setIsHit(): void
    {
        $this->isHit = true;
    }

    public function getShip(): Ship
    {
        return $this->ship;
    }

    public function setShip(Ship $ship): void
    {
        $this->ship = $ship;
    }
}
