<?php

declare(strict_types=1);

namespace App\Data\Models;

use App\Exceptions\CannotPlaceShip;

final class Board
{
    public const SIZE = 10;
    public const MAX_NUMBER_OF_SHIPS = 3;

    /** @var array<\App\Data\Models\Target> */
    private array $targets;

    /** @var array<\App\Data\Models\Ship\Ship> */
    private array $ships;

    /**
     * @param array<\App\Data\Models\Ship\Ship> $ships
     * @throws \App\Exceptions\CannotPlaceShip
     */
    public function __construct(array $ships)
    {
        if (count($ships) === 0) {
            $errorMessage =
                'There must be at least 1 ship on this board. ' .
                'Please check your input and try again.';
            throw new CannotPlaceShip($errorMessage);
        }

        if (count($ships) > self::MAX_NUMBER_OF_SHIPS) {
            $errorMessage =
                'There can only be ' .
                self::MAX_NUMBER_OF_SHIPS .
                ' ships on this board. Please check your input ' .
                ' and try again.';
            throw new CannotPlaceShip($errorMessage);
        }

        $this->ships = $ships;
        $this->initializeBoard();

        var_dump($this->targets, $this->ships);
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

        //        for ($row = 1; $row <= self::SIZE; $row += 1) {
        //            $rowLetter = $this->getGridLetterByIndex($row);
        //
        //            for ($column = 1; $column <= self::SIZE; $column += 1) {
        //                $this->grid[$rowLetter][$column] = null;
        //            }
        //        }
    }

    /** @return array<array<string>> */
    public function getTargets(): array
    {
        return $this->targets;
    }

    /** @return array<\App\Data\Models\Ship> */
    public function getShips(): array
    {
        return $this->ships;
    }
}
