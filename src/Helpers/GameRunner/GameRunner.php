<?php

declare(strict_types=1);

namespace App\Helpers\GameRunner;

use App\Helpers\GameProcessor;
use App\Helpers\Renderer\Renderer;

interface GameRunner
{
    public function run(GameProcessor $gameProcessor, Renderer $renderer): void;
}
