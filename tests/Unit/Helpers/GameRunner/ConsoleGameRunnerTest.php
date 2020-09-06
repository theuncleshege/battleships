<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers\GameRunner;

use App\Helpers\GameProcessor;
use App\Helpers\GameRunner\ConsoleGameRunner;
use App\Helpers\Renderer\ConsoleRenderer;
use App\Models\Game;
use PHPUnit\Framework\TestCase;

final class ConsoleGameRunnerTest extends TestCase
{
    public function testRun(): void
    {
        $gameProcessor = $this->createMock(GameProcessor::class);
        $renderer = $this->createMock(ConsoleRenderer::class);
        $consoleGameRunner = $this->getMockBuilder(ConsoleGameRunner::class)
            ->onlyMethods(['fopen', 'fgets'])
            ->setConstructorArgs([$this->createMock(Game::class)])
            ->getMock();

        $consoleGameRunner
            ->expects(self::once())
            ->method('fopen')
            ->willReturn(true);

        $consoleGameRunner
            ->expects(self::once())
            ->method('fgets')
            ->willReturn('A1');

        $renderer
            ->expects(self::exactly(2))
            ->method('render')
            ->withConsecutive(
                ['', false],
                [GameProcessor::HANDLE_GAME_OVER, false],
            );

        $gameProcessor
            ->expects(self::once())
            ->method('processInput')
            ->willReturn(GameProcessor::HANDLE_GAME_OVER);

        $consoleGameRunner->run($gameProcessor, $renderer);
    }

    public function testRuninCheatMode(): void
    {
        $gameProcessor = $this->createMock(GameProcessor::class);
        $renderer = $this->createMock(ConsoleRenderer::class);
        $consoleGameRunner = $this->getMockBuilder(ConsoleGameRunner::class)
            ->onlyMethods(['fopen', 'fgets'])
            ->setConstructorArgs([$this->createMock(Game::class)])
            ->getMock();

        $consoleGameRunner
            ->expects(self::once())
            ->method('fopen')
            ->willReturn(true);

        $consoleGameRunner
            ->expects(self::exactly(2))
            ->method('fgets')
            ->willReturnOnConsecutiveCalls('show', 'A1');

        $renderer
            ->expects(self::exactly(3))
            ->method('render')
            ->withConsecutive(
                ['', false],
                ['', true],
                [GameProcessor::HANDLE_GAME_OVER, false],
            );

        $gameProcessor
            ->expects(self::once())
            ->method('processInput')
            ->willReturn(GameProcessor::HANDLE_GAME_OVER);

        $consoleGameRunner->run($gameProcessor, $renderer);
    }
}
