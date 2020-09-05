<?php

declare(strict_types=1);

use App\Data\Models\Board;
use App\Data\Models\Ship\Destroyer;
use App\Exceptions\CannotPlaceShip;
use App\Helpers\ShipPlacement\RandomShipPlacement;

require __DIR__ . '/vendor/autoload.php';

try {
    $destroyer = new Destroyer();
    $ships = [$destroyer];
    $board = new Board($ships);
    $shipPlacement = new RandomShipPlacement(5);

    var_dump($shipPlacement->placeShipsOnBoard($board));
    var_dump($destroyer->getTargets());
} catch (CannotPlaceShip $e) {
    echo $e->getMessage() . "\n\n";
}
