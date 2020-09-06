<?php

declare(strict_types=1);

namespace App\Helpers\Renderer;

use App\Models\Target;

abstract class Renderer
{
    protected string $emptySpace = ' ';
    protected string $newLine = PHP_EOL;
    protected string $targetMissed = '-';
    protected string $targetHit = 'X';
    protected string $targetUntouched = '.';

    abstract public function render(string $result, bool $isCheatMode): void;

    final protected function renderTarget(Target $target): string
    {
        if ($target->isOccupied() && $target->isHit()) {
            $output = $this->targetHit;
        } elseif ($target->isHit()) {
            $output = $this->targetMissed;
        } else {
            $output = $this->targetUntouched;
        }

        return $output . str_repeat($this->emptySpace, 2);
    }

    final protected function renderTargetWithCheat(Target $target): string
    {
        $output = $target->isOccupied() ? $this->targetHit : $this->emptySpace;
        return $output . str_repeat($this->emptySpace, 2);
    }
}
