<?php

declare(strict_types=1);

namespace App\Helpers\ShipPlacement;

use App\Models\Board;

interface ShipPlacement
{
    public const DIRECTION_VERTICAL = 'vertical';
    public const DIRECTION_HORIZONTAL = 'horizontal';

    /** @throws \App\Exceptions\CannotPlaceShip */
    public function placeShipsOnBoard(Board $board): bool;
}
