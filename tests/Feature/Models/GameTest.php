<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Helpers\GameProcessor;
use App\Helpers\GameRunner\ConsoleGameRunner;
use App\Helpers\Renderer\ConsoleRenderer;
use App\Helpers\ShipPlacement\RandomShipPlacement;
use App\Helpers\Validator\InputValidator;
use App\Models\Board;
use App\Models\Game;
use App\Models\Ship\Destroyer;
use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{
    public function testStartGame(): void
    {
        $ships = [new Destroyer(), new Destroyer()];
        $board = new Board($ships);
        $targets = array_keys($board->getTargets());
        //        $shipPlacement = new RandomShipPlacement(5);
        $shipPlacement = $this->getMockBuilder(RandomShipPlacement::class)
            ->onlyMethods(['rand'])
            ->setConstructorArgs([5])
            ->getMock();

        $shipPlacement
            ->expects(self::any())
            ->method('rand')
            ->willReturnOnConsecutiveCalls(0, 1, 0, 1, 0);

        $game = new Game($board, $shipPlacement);
        $gameProcessor = new GameProcessor(new InputValidator());

        $consoleGameRunner = $this->getMockBuilder(ConsoleGameRunner::class)
            ->onlyMethods(['fopen', 'fgets'])
            ->setConstructorArgs([$game])
            ->getMock();

        $consoleGameRunner
            ->expects(self::once())
            ->method('fopen')
            ->willReturn(true);

        $consoleGameRunner
            ->expects(self::any())
            ->method('fgets')
            ->willReturnOnConsecutiveCalls('show', 'A1', ...$targets);

        $game->setRenderer(new ConsoleRenderer($game));

        $game->startGame($consoleGameRunner, $gameProcessor);

        $expectedRegex =
            '/\bWell done! You completed the game in \d{1,3} shots\b/';

        self::expectOutputRegex($expectedRegex);
    }
}
