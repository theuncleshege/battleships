<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\CannotInitializeBoard;

final class Board
{
    public const SIZE = 10;
    public const MAX_NUMBER_OF_SHIPS = 3;

    /** @var array<\App\Models\Target> */
    private array $targets;

    /** @var array<\App\Models\Ship\Ship> */
    private array $ships;

    /**
     * @param array<\App\Models\Ship\Ship> $ships
     * @throws \App\Exceptions\CannotInitializeBoard
     */
    public function __construct(array $ships)
    {
        if (count($ships) === 0) {
            $errorMessage =
                'There must be at least 1 ship on this board. ' .
                'Please check your input and try again.';
            throw new CannotInitializeBoard($errorMessage);
        }

        if (count($ships) > self::MAX_NUMBER_OF_SHIPS) {
            $errorMessage =
                'There can only be ' .
                self::MAX_NUMBER_OF_SHIPS .
                ' ships on this board. Please check your input ' .
                ' and try again.';
            throw new CannotInitializeBoard($errorMessage);
        }

        $this->ships = $ships;
        $this->initializeBoard();
    }

    private function initializeBoard(): void
    {
        for ($index = 1; $index <= self::SIZE; $index += 1) {
            $rowLetter = getLetterByIndex($index);

            for ($column = 1; $column <= self::SIZE; $column += 1) {
                $targetName = $rowLetter . $column;
                $this->targets[$targetName] = new Target($targetName);
            }
        }
    }

    /** @return array<\App\Models\Target> */
    public function getTargets(): array
    {
        return $this->targets;
    }

    /** @return array<\App\Models\Ship\Ship> */
    public function getShips(): array
    {
        return $this->ships;
    }
}
