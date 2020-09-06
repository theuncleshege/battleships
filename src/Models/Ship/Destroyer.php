<?php

declare(strict_types=1);

namespace App\Models\Ship;

final class Destroyer extends Ship
{
    public function getName(): string
    {
        return 'Destroyer';
    }

    public function getSize(): int
    {
        return 2;
    }
}
