<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Exceptions\CannotInitializeBoard;
use App\Models\Board;
use App\Models\Ship\BattleShip;
use App\Models\Ship\Destroyer;
use App\Models\Ship\Ship;
use App\Models\Target;
use PHPUnit\Framework\TestCase;

final class BoardTest extends TestCase
{
    private Board $board;

    /** @var array<\App\Models\Ship\Ship> */
    private array $ships;

    public function testBoardCanGetTargets(): void
    {
        $targets = $this->board->getTargets();
        $array = array_reverse($targets);

        self::assertCount(pow(Board::SIZE, 2), $targets);
        self::assertInstanceOf(Target::class, array_pop($array));
    }

    public function testBoardCanGetShips(): void
    {
        $ships = $this->board->getShips();
        $array = array_reverse($ships);

        self::assertCount(count($this->ships), $ships);
        self::assertInstanceOf(Ship::class, array_pop($array));
    }

    public function testBoardWillThrowExceptionOnShipsLimitExceeded(): void
    {
        self::expectException(CannotInitializeBoard::class);

        $this->ships[] = new BattleShip();

        new Board($this->ships);
    }

    public function testBoardWillThrowExceptionOnZeroShips(): void
    {
        self::expectException(CannotInitializeBoard::class);

        $this->ships = [];

        new Board($this->ships);
    }

    protected function setUp(): void
    {
        $this->ships = [new BattleShip(), new Destroyer(), new Destroyer()];
        $this->board = new Board($this->ships);
    }
}
