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
        $stdin = $this->fopen('php://stdin', 'r');

        $renderer->render($result, $isCheatMode);

        while (true) {
            $result = '';
            $rawInput = $stdin !== false ? $this->fgets($stdin) : false;
            $input = $rawInput !== false ? trim($rawInput) : '';

            if ($input === 'show') {
                $isCheatMode = true;
            }

            if ($input !== '' && !$isCheatMode) {
                $result = $gameProcessor->processInput($this->game, $input);
            }

            $renderer->render($result, $isCheatMode);
            $isCheatMode = false;

            if ($result === GameProcessor::HANDLE_GAME_OVER) {
                break;
            }
        }
    }

    // @codeCoverageIgnoreStart
    /** @return resource|false a file pointer resource on success, or false on error. */
    // @phpstan-ignore-next-line
    protected function fopen(string $filename, string $mode)
    {
        return fopen($filename, $mode);
    }

    /**
     * @param resource $handle
     * @return string|false
     */
    // @phpstan-ignore-next-line
    protected function fgets($handle)
    {
        return fgets($handle);
    }
    // @codeCoverageIgnoreEnd
}
