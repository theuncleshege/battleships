<?php

declare(strict_types=1);

namespace App\Models\Ship;

final class BattleShip extends Ship
{
    public function getName(): string
    {
        return 'BattleShip';
    }

    public function getSize(): int
    {
        return 5;
    }
}
