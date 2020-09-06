<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Ship\Ship;
use App\Models\Target;
use PHPUnit\Framework\TestCase;

final class TargetTest extends TestCase
{
    public Target $target;
    private string $targetName = 'A1';

    public function testATargetKnowsItsName(): void
    {
        self::assertEquals($this->targetName, $this->target->getName());
    }

    public function testATargetCanTrackItsOccupiedStatus(): void
    {
        self::assertEquals(false, $this->target->isOccupied());
        $this->target->setIsOccupied();
        self::assertEquals(true, $this->target->isOccupied());
    }

    public function testATargetCanTrackItsHitStatus(): void
    {
        self::assertEquals(false, $this->target->isHit());
        $this->target->setIsHit();
        self::assertEquals(true, $this->target->isHit());
    }

    public function testATargetKnowsItsShip(): void
    {
        $ship = $this->createMock(Ship::class);
        $this->target->setShip($ship);
        self::assertEquals($ship, $this->target->getShip());
    }

    protected function setUp(): void
    {
        $this->target = new Target($this->targetName);
    }
}
