<?php

declare(strict_types=1);

use App\Exceptions\CannotInitializeBoard;
use App\Helpers\GameRunner\ConsoleGameRunner;
use App\Helpers\ShipPlacement\RandomShipPlacement;
use App\Models\Board;
use App\Models\Game;
use App\Models\Ship\BattleShip;
use App\Models\Ship\Destroyer;

require __DIR__ . '/vendor/autoload.php';

try {
    $ships = [new BattleShip(), new Destroyer(), new Destroyer()];
    $board = new Board($ships);
    $shipPlacement = new RandomShipPlacement(5);

    $game = new Game($board, $shipPlacement);
    $gameRunner = new ConsoleGameRunner($game);
    $game->startGame($gameRunner);
} catch (CannotInitializeBoard $e) {
    echo $e->getMessage() . "\n\n";
}
