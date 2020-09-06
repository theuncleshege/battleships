<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use App\Helpers\GameProcessor;
use App\Helpers\Validator\InputValidator;
use App\Models\Board;
use App\Models\Game;
use App\Models\Target;
use PHPUnit\Framework\TestCase;

final class GameProcessorTest extends TestCase
{
    public function testGameProcessorCanProcessInvalidInput(): void
    {
        $input = 'invalid';
        $game = $this->createMock(Game::class);
        $validator = $this->createMock(InputValidator::class);

        $validator
            ->expects(self::once())
            ->method('isValid')
            ->with($input)
            ->willReturn(false);

        $gameProcessor = new GameProcessor($validator);
        $result = $gameProcessor->processInput($game, $input);

        self::assertEquals($result, $validator->getErrorMessage());
    }

    /*public function testGameProcessorCanProcessTargetIsAlreadyHit(): void
    {
        $input = 'A1';
        $game = $this->createMock(Game::class);
        $validator = $this->createMock(InputValidator::class);
        $board = $this->createMock(Board::class);
        $target = $this->createMock(Target::class);

        $validator
            ->expects(self::once())
            ->method('isValid')
            ->with($input)
            ->willReturn(true);

        $game->expects(self::once())->method('incrementShotsTaken');

        $game
            ->expects(self::once())
            ->method('getBoard')
            ->willReturn($board);

        $board
            ->expects(self::once())
            ->method('getTargetFromInput')
            ->willReturn($target);

        $gameProcessor = new GameProcessor($validator);
        $result = $gameProcessor->processInput($game, $input);

        self::assertEquals($result, 'Miss');
    }*/

    public function testGameProcessorCanProcessValidInput(): void
    {
        $input = 'A1';
        $game = $this->createMock(Game::class);
        $validator = $this->createMock(InputValidator::class);
        $board = $this->createMock(Board::class);
        $target = $this->createMock(Target::class);
        $targets = [$input => $target];

        $validator
            ->expects(self::once())
            ->method('isValid')
            ->with($input)
            ->willReturn(true);

        $game->expects(self::once())->method('incrementShotsTaken');

        $game
            ->expects(self::once())
            ->method('getBoard')
            ->willReturn($board);

        $board
            ->expects(self::once())
            ->method('getTargets')
            ->willReturn($targets);

        $gameProcessor = new GameProcessor($validator);
        $result = $gameProcessor->processInput($game, $input);

        self::assertEquals($result, 'Miss');
    }
}
