<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\CannotPlaceShip;
use App\Helpers\GameProcessor;
use App\Helpers\GameRunner\GameRunner;
use App\Helpers\Renderer\ConsoleRenderer;
use App\Helpers\ShipPlacement\ShipPlacement;
use App\Helpers\Validator\InputValidator;

final class Game
{
    private Board $board;
    private ShipPlacement $shipPlacement;
    private int $shotsTaken = 0;

    public function __construct(Board $board, ShipPlacement $shipPlacement)
    {
        $this->board = $board;
        $this->shipPlacement = $shipPlacement;
    }

    public function startGame(GameRunner $gameRunner): void
    {
        try {
            $this->shipPlacement->placeShipsOnBoard($this->board);

            $gameProcessor = new GameProcessor(new InputValidator());
            $gameRunner->run($gameProcessor, new ConsoleRenderer($this));
        } catch (CannotPlaceShip $e) {
            echo $e->getMessage() . "\n\n";
            exit();
        }
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getShotsTaken(): int
    {
        return $this->shotsTaken;
    }

    public function incrementShotsTaken(): void
    {
        $this->shotsTaken += 1;
    }
}
