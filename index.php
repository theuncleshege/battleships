<?php

declare(strict_types=1);

use App\Exceptions\CannotInitializeBoard;
use App\Helpers\GameProcessor;
use App\Helpers\GameRunner\ConsoleGameRunner;
use App\Helpers\Renderer\ConsoleRenderer;
use App\Helpers\ShipPlacement\RandomShipPlacement;
use App\Helpers\Validator\InputValidator;
use App\Models\Board;
use App\Models\Game;
use App\Models\Ship\Destroyer;

require __DIR__ . '/vendor/autoload.php';

try {
    //    $ships = [new BattleShip(), new Destroyer(), new Destroyer()];
    $ships = [new Destroyer()];
    $board = new Board($ships);
    $shipPlacement = new RandomShipPlacement(5);

    $game = new Game($board, $shipPlacement);
    $gameRunner = new ConsoleGameRunner($game);
    $gameProcessor = new GameProcessor(new InputValidator());

    $game->setRenderer(new ConsoleRenderer($game));
    $game->startGame($gameRunner, $gameProcessor);
} catch (CannotInitializeBoard $e) {
    echo $e->getMessage() . "\n\n";
}
