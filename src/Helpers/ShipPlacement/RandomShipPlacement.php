<?php

declare(strict_types=1);

namespace App\Helpers\ShipPlacement;

use App\Exceptions\CannotPlaceShip;
use App\Models\Board;
use App\Models\Ship\Ship;
use App\Models\Target;

final class RandomShipPlacement implements ShipPlacement
{
    private int $maxNumberOfRetries;

    /** @var array<\App\Models\Target> */
    private array $targets;

    public function __construct(int $numberOfRetries)
    {
        $this->maxNumberOfRetries = $numberOfRetries;
    }

    public function placeShipsOnBoard(Board $board): bool
    {
        $this->targets = $board->getTargets();
        $ships = $board->getShips();

        foreach ($ships as $ship) {
            $areShipsPlaced = false;

            for (
                $retries = 0;
                $retries < $this->maxNumberOfRetries;
                $retries += 1
            ) {
                $direction =
                    $this->rand(0, 1) === 0
                        ? ShipPlacement::DIRECTION_VERTICAL
                        : ShipPlacement::DIRECTION_HORIZONTAL;

                if ($this->placeShipOnBoardWithDirection($ship, $direction)) {
                    $areShipsPlaced = true;
                    break;
                }
            }

            if ($areShipsPlaced === false) {
                throw new CannotPlaceShip(
                    sprintf(
                        'Failed to place ships after %d retries',
                        $this->maxNumberOfRetries,
                    ),
                );
            }
        }

        return true;
    }

    // @codeCoverageIgnoreStart
    // @phpstan-ignore-next-line
    protected function rand(int $start, int $end): int
    {
        return rand($start, $end);
    }

    // @codeCoverageIgnoreEnd

    private function placeShipOnBoardWithDirection(
        Ship $ship,
        string $direction
    ): bool {
        $startPosition = rand(1, Board::SIZE);
        $shipSize = $ship->getSize();

        if ($this->isShipWithinBounds($startPosition, $shipSize) === false) {
            return false;
        }

        if ($this->areTargetsAvailable($startPosition, $direction) === false) {
            return false;
        }

        $this->setShipTargets($ship, $startPosition, $direction);

        return true;
    }

    private function isShipWithinBounds(int $startPosition, int $shipSize): bool
    {
        return $startPosition + $shipSize <= Board::SIZE;
    }

    // @phpstan-ignore-next-line
    protected function areTargetsAvailable(
        int $startPosition,
        string $direction
    ): bool {
        for ($i = $startPosition; $i < Board::SIZE; $i += 1) {
            $target = $this->getCurrentTarget($startPosition, $direction, $i);

            if ($target->isOccupied()) {
                return false;
            }
        }

        return true;
    }

    private function getCurrentTarget(
        int $startPosition,
        string $direction,
        int $currentIndex
    ): Target {
        $rowLetter = '';
        $columnNumber = 0;

        if ($direction === ShipPlacement::DIRECTION_VERTICAL) {
            $rowLetter = getLetterByIndex($currentIndex);
            $columnNumber = $startPosition;
        } elseif ($direction === ShipPlacement::DIRECTION_HORIZONTAL) {
            $rowLetter = getLetterByIndex($startPosition);
            $columnNumber = $currentIndex;
        }

        $targetName = $rowLetter . $columnNumber;
        return $this->targets[$targetName];
    }

    private function setShipTargets(
        Ship $ship,
        int $startPosition,
        string $direction
    ): void {
        $shipTargets = [];
        $shipSize = $ship->getSize();

        for ($i = $startPosition; $i < $startPosition + $shipSize; $i += 1) {
            $target = $this->getCurrentTarget($startPosition, $direction, $i);

            $target->setIsOccupied();
            $target->setShip($ship);
            $shipTargets[$target->getName()] = $target;
        }

        $ship->setTargets($shipTargets);
    }
}
