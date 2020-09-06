<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers\ShipPlacement;

use App\Exceptions\CannotPlaceShip;
use App\Helpers\ShipPlacement\RandomShipPlacement;
use App\Models\Board;
use App\Models\Ship\Destroyer;
use App\Models\Target;
use PHPUnit\Framework\TestCase;

final class RandomShipPlacementTest extends TestCase
{
    public function testPlaceShipsOnBoard(): void
    {
        $ships = [$this->createMock(Destroyer::class)];

        $targets = [
            $this->createMock(Target::class),
            $this->createMock(Target::class),
        ];

        $board = $this->createMock(Board::class);

        $board
            ->expects(self::once())
            ->method('getTargets')
            ->willReturn($targets);

        $board
            ->expects(self::once())
            ->method('getShips')
            ->willReturn($ships);

        $randomShipPlacement = $this->getMockBuilder(RandomShipPlacement::class)
            ->onlyMethods(['areTargetsAvailable', 'rand'])
            ->setConstructorArgs([2])
            ->getMock();

        $randomShipPlacement
            ->expects(self::exactly(2))
            ->method('areTargetsAvailable')
            ->willReturnOnConsecutiveCalls(false, true);

        $randomShipPlacement
            ->expects(self::any())
            ->method('rand')
            ->willReturn(0);

        self::assertTrue($randomShipPlacement->placeShipsOnBoard($board));
    }

    public function testPlaceShipsOnBoardWithException(): void
    {
        self::expectException(CannotPlaceShip::class);

        $ships = [$this->createMock(Destroyer::class)];

        $targets = [
            $this->createMock(Target::class),
            $this->createMock(Target::class),
        ];

        $board = $this->createMock(Board::class);

        $board
            ->expects(self::once())
            ->method('getTargets')
            ->willReturn($targets);

        $board
            ->expects(self::once())
            ->method('getShips')
            ->willReturn($ships);

        $randomShipPlacement = $this->getMockBuilder(RandomShipPlacement::class)
            ->onlyMethods(['areTargetsAvailable', 'rand'])
            ->setConstructorArgs([1])
            ->getMock();

        $randomShipPlacement
            ->expects(self::once())
            ->method('areTargetsAvailable')
            ->willReturnOnConsecutiveCalls(false);

        $randomShipPlacement
            ->expects(self::any())
            ->method('rand')
            ->willReturn(1);

        $randomShipPlacement->placeShipsOnBoard($board);
    }
}
