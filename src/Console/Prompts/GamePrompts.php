<?php

declare(strict_types=1);

namespace Rpg\Console\Prompts;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Rpg\Console\CustomStyle;
use RuntimeException;
use Symfony\Component\Console\Helper\TableStyle;

class GamePrompts
{
    public function __construct(private CustomStyle $io) {}

    public function askName(): string
    {
        return $this->io->ask(
            question: 'Enter your name',
            validator: function ($answer) {
                if (Str::of($answer)->trim()->length() < 2) {
                    throw new RuntimeException('Name must be at least 2 characters');
                }

                return $answer;
            }
        );
    }

    public function chooseWeapon(): string
    {
        $table = $this->io->createTable();

        $tableStyle = new TableStyle;

        $tableStyle
            ->setHorizontalBorderChars('-')
            ->setVerticalBorderChars('|');

        $table->setStyle($tableStyle);

        $weapons = Collection::make(Config::get('weapons'));

        $weapons->each(function (array $stats, string $name) use ($table) {
            $weapon = Str::title($name);
            $table->addRow(
                [
                    "<fg=bright-cyan>$weapon</>",
                    "<fg=yellow>{$stats['damage']}</>",
                    "<fg=gray>{$stats['description']}</>",
                ]);
        });

        $table->render();

        $this->io->writeln('');

        $choice = $this->io->choice(
            question: 'Choose your weapon',
            choices: $weapons->keys()->map(fn ($key) => Str::title($key))->all(),
        );

        return Str::lower($choice);
    }

    public function confirmReady(): bool
    {
        return $this->io->confirm('Are you ready to begin?');
    }

    public function chooseCombatAction(): string
    {
        return $this->io->choice(
            question: 'What will you do?',
            choices: [
                '⚔️  Attack',
                '🏃 Run',
            ],
            default: 1
        );
    }
}
