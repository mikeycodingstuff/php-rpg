<?php

declare(strict_types=1);

namespace Rpg\Console\Command;

use Illuminate\Support\Sleep;
use Rpg\Console\CustomStyle;
use Rpg\Console\Display\GameDisplay;
use Rpg\Console\Prompts\GamePrompts;
use Rpg\Game;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'play', description: 'Play the game!')]
class PlayCommand
{
    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        $io = new CustomStyle($input, $output);
        $cursor = new Cursor($output);
        $display = new GameDisplay($io);
        $prompts = new GamePrompts($io);
        $game = new Game($display, $prompts, $cursor);

        $cursor->clearScreen();
        $display->showTitle();
        Sleep::for(0.5)->seconds();

        $game->start();

        return Command::SUCCESS;
    }
}
