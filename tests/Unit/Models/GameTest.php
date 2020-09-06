<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Exceptions\CannotPlaceShip;
use App\Helpers\GameProcessor;
use App\Helpers\GameRunner\ConsoleGameRunner;
use App\Helpers\Renderer\ConsoleRenderer;
use App\Helpers\ShipPlacement\RandomShipPlacement;
use App\Models\Board;
use App\Models\Game;
use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{
    public Game $game;
    public RandomShipPlacement $shipPlacement;
    public GameProcessor $gameProcessor;
    public ConsoleRenderer $consoleRenderer;
    private Board $board;

    public function testStartGame(): void
    {
        $gameRunner = $this->createMock(ConsoleGameRunner::class);
        $shipPlacement = $this->createMock(RandomShipPlacement::class);
        $consoleRenderer = $this->createMock(ConsoleRenderer::class);

        $game = new Game($this->board, $shipPlacement);
        $game->setRenderer($consoleRenderer);

        $shipPlacement
            ->expects(self::once())
            ->method('placeShipsOnBoard')
            ->with($this->board);

        $gameRunner
            ->expects(self::once())
            ->method('run')
            ->with($this->gameProcessor, $consoleRenderer);

        $game->startGame($gameRunner, $this->gameProcessor);
    }

    public function testStartGameWilThrowException(): void
    {
        $gameRunner = $this->createMock(ConsoleGameRunner::class);
        $shipPlacement = $this->createMock(RandomShipPlacement::class);
        $consoleRenderer = $this->createMock(ConsoleRenderer::class);
        $cannotPlaceShip = $this->createMock(CannotPlaceShip::class);

        $game = new Game($this->board, $shipPlacement);
        $game->setRenderer($consoleRenderer);

        $shipPlacement
            ->expects(self::once())
            ->method('placeShipsOnBoard')
            ->with($this->board)
            ->willThrowException($cannotPlaceShip);

        $game->startGame($gameRunner, $this->gameProcessor);
    }

    public function testGameCanGetBoard(): void
    {
        self::assertEquals($this->board, $this->game->getBoard());
    }

    public function testGameCanTrackShotsTaken(): void
    {
        $this->game->incrementShotsTaken();
        $this->game->incrementShotsTaken();

        self::assertEquals(2, $this->game->getShotsTaken());
    }

    protected function setUp(): void
    {
        $this->board = $this->createMock(Board::class);
        $this->shipPlacement = $this->createMock(RandomShipPlacement::class);
        $this->gameProcessor = $this->createMock(GameProcessor::class);
        $this->consoleRenderer = $this->createMock(ConsoleRenderer::class);

        $this->game = new Game($this->board, $this->shipPlacement);
        $this->game->setRenderer($this->consoleRenderer);
    }
}
