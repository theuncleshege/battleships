<?php

declare(strict_types=1);

namespace App\Helpers\Renderer;

use App\Helpers\GameProcessor;
use App\Models\Board;
use App\Models\Game;

final class ConsoleRenderer extends Renderer
{
    private Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function render(string $result, bool $isCheatMode): void
    {
        if ($result === GameProcessor::HANDLE_GAME_OVER) {
            echo 'Sunk' . $this->newLine;
        } elseif ($result !== '') {
            echo $result . $this->newLine;
        }

        $this->printColumnTitles();

        $targets = $this->game->getBoard()->getTargets();

        for ($rowNumber = 1; $rowNumber <= Board::SIZE; $rowNumber += 1) {
            $row = getLetterByIndex($rowNumber);
            echo $row;
            echo $this->emptySpace;

            for (
                $columnNumber = 1;
                $columnNumber <= Board::SIZE;
                $columnNumber += 1
            ) {
                $target = $targets[$row . $columnNumber];

                if ($isCheatMode) {
                    echo $this->renderTargetWithCheat($target);
                } else {
                    echo $this->renderTarget($target);
                }
            }

            echo $this->newLine;
        }

        echo $this->newLine;

        if ($result === GameProcessor::HANDLE_GAME_OVER) {
            $this->renderGameOver($this->game);
        } else {
            echo 'Enter coordinates (row, col), e.g. A5 = ';
        }
    }

    private function printColumnTitles(): void
    {
        echo $this->newLine;

        for ($colNumber = 1; $colNumber <= Board::SIZE; $colNumber += 1) {
            if ($colNumber === 1) {
                echo str_repeat($this->emptySpace, 2);
            }

            echo $colNumber . str_repeat($this->emptySpace, 2);
        }

        echo $this->newLine;
    }

    private function renderGameOver(Game $game): void
    {
        echo sprintf(
            'Well done! You completed the game in %d shots',
            $game->getShotsTaken(),
        );
        echo $this->newLine;
    }
}
