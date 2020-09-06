<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Ship;

use App\Models\Ship\BattleShip;
use PHPUnit\Framework\TestCase;

final class BattleShipTest extends TestCase
{
    private BattleShip $battleShip;

    public function testBattleShipCanGetName(): void
    {
        self::assertEquals('BattleShip', $this->battleShip->getName());
    }

    public function testBattleShipCanGetSize(): void
    {
        self::assertEquals(5, $this->battleShip->getSize());
    }

    protected function setUp(): void
    {
        $this->battleShip = new BattleShip();
    }
}
