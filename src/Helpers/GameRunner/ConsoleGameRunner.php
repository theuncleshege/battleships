<?php

declare(strict_types=1);

namespace App\Helpers\GameRunner;

use App\Helpers\GameProcessor;
use App\Helpers\Renderer\Renderer;
use App\Models\Game;

final class ConsoleGameRunner implements GameRunner
{
    public Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function run(GameProcessor $gameProcessor, Renderer $renderer): void
    {
        $isCheatMode = false;
        $result = '';
        $stdin = fopen('php://stdin', 'r');

        $renderer->render($result, $isCheatMode);

        while (true) {
            $rawInput = $stdin !== false ? fgets($stdin) : false;
            $input = $rawInput !== false ? trim($rawInput) : '';

            if ($input === 'show') {
                $input = '';
                $isCheatMode = true;
            }

            if ($input !== '') {
                $result = $gameProcessor->processInput($this->game, $input);
            }

            $renderer->render($result, $isCheatMode);
            $isCheatMode = false;

            if ($result === GameProcessor::HANDLE_GAME_OVER) {
                break;
            }
        }
    }
}
