<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Ship;

use App\Models\Ship\Destroyer;
use App\Models\Target;
use PHPUnit\Framework\TestCase;

final class ShipTest extends TestCase
{
    public function testShipCanTellWhenSunk(): void
    {
        $targets = [
            $this->createMock(Target::class),
            $this->createMock(Target::class),
        ];

        $ship = new Destroyer();
        $ship->setTargets($targets);

        $ship->incrementShots();

        self::assertFalse($ship->isSunk());

        $ship->incrementShots();

        self::assertTrue($ship->isSunk());
    }
}
