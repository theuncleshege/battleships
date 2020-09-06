<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Helpers\Validator\Validator;
use App\Models\Board;
use App\Models\Game;
use App\Models\Target;

final class GameProcessor
{
    public const HANDLE_RESULT_HIT = 'Hit';
    public const HANDLE_RESULT_MISS = 'Miss';
    public const HANDLE_RESULT_ERROR = 'Error';
    public const HANDLE_RESULT_SUNK = 'Sunk';
    public const HANDLE_GAME_OVER = 'Game Over';

    private Validator $inputValidator;

    public function __construct(Validator $validator)
    {
        $this->inputValidator = $validator;
    }

    public function processInput(Game $game, string $input): string
    {
        if (!$this->inputValidator->isValid($input)) {
            return self::HANDLE_RESULT_ERROR;
        }

        $game->incrementShotsTaken();

        $board = $game->getBoard();
        $target = $this->getTargetFromInput($board, $input);

        if ($target->isHit()) {
            return self::HANDLE_RESULT_MISS;
        }

        $target->setIsHit();

        if (!$target->isOccupied()) {
            return self::HANDLE_RESULT_MISS;
        }

        $ship = $target->getShip();
        $ship->incrementShots();

        if ($this->isGameOver($board->getShips())) {
            return self::HANDLE_GAME_OVER;
        }

        if ($ship->isSunk()) {
            return self::HANDLE_RESULT_SUNK;
        }

        return self::HANDLE_RESULT_HIT;
    }

    private function getTargetFromInput(Board $board, string $input): Target
    {
        $targets = $board->getTargets();
        $input = strtoupper(substr($input, 0, 1)) . substr($input, 1, 2);

        return $targets[$input];
    }

    /** @param array<\App\Models\Ship\Ship> $ships */
    private function isGameOver(array $ships): bool
    {
        foreach ($ships as $ship) {
            if ($ship->isSunk() === false) {
                return false;
            }
        }

        return true;
    }
}
