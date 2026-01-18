<?php

declare(strict_types=1);

namespace Rpg\Console\Prompts;

use Illuminate\Support\Str;
use Rpg\Console\CustomStyle;
use RuntimeException;

class GamePrompts
{
    public function __construct(private CustomStyle $io) {}

    public function askName(): string
    {
        return $this->io->ask(
            question: 'Enter your name: ',
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
        return $this->io->choice(
            question: 'Choose your weapon:',
            choices: [
                '⚔️  Sword (balanced damage)',
                '🪓 Axe (heavy damage)',
                '🗡️  Dagger (quick strikes)',
            ],
            default: 0,
        );
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
