<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Ship;

use App\Models\Ship\Destroyer;
use PHPUnit\Framework\TestCase;

final class DestroyerTest extends TestCase
{
    private Destroyer $destroyer;

    public function testDestroyerCanGetName(): void
    {
        self::assertEquals('Destroyer', $this->destroyer->getName());
    }

    public function testDestroyerCanGetSize(): void
    {
        self::assertEquals(2, $this->destroyer->getSize());
    }

    protected function setUp(): void
    {
        $this->destroyer = new Destroyer();
    }
}
