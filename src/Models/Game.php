<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\CannotPlaceShip;
use App\Helpers\GameProcessor;
use App\Helpers\GameRunner\GameRunner;
use App\Helpers\Renderer\Renderer;
use App\Helpers\ShipPlacement\ShipPlacement;

final class Game
{
    private Board $board;
    private ShipPlacement $shipPlacement;
    private int $shotsTaken = 0;
    private Renderer $renderer;

    public function __construct(Board $board, ShipPlacement $shipPlacement)
    {
        $this->board = $board;
        $this->shipPlacement = $shipPlacement;
    }

    public function startGame(
        GameRunner $gameRunner,
        GameProcessor $gameProcessor
    ): void {
        try {
            $this->shipPlacement->placeShipsOnBoard($this->board);
            $gameRunner->run($gameProcessor, $this->renderer);
        } catch (CannotPlaceShip $e) {
            echo $e->getMessage() . "\n\n";
            exit();
        }
    }

    public function setRenderer(Renderer $renderer): void
    {
        $this->renderer = $renderer;
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
