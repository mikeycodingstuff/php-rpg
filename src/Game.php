<?php

declare(strict_types=1);

namespace Rpg;

class Game
{
    private Player $player;

    public function start(): void
    {
        $this->player = $this->createPlayer();
        $this->startAdventure();
    }

    private function createPlayer(): Player
    {
        echo "=== Character Creation ===\n";

        $name = $this->promptUntilValid(
            'Enter your name: ',
            fn ($input) => strlen(trim($input)) >= 2,
            'Name must be at least 2 characters'
        );

        $age = (int) $this->promptUntilValid(
            'Age: ',
            fn ($input) => is_numeric($input) && $input >= 10 && $input <= 100,
            'Age must be between 10 and 100'
        );

        echo "Choose your weapon:\n";
        echo "  [1] Sword (balanced)\n";
        echo "  [2] Axe (heavy damage)\n";
        echo "  [3] Dagger (quick strikes)\n";

        $weaponChoice = $this->promptUntilValid(
            'Choice: ',
            fn ($input) => in_array($input, ['1', '2', '3']),
            'Please choose 1, 2, or 3'
        );

        $weapon = match ($weaponChoice) {
            '1' => 'sword',
            '2' => 'axe',
            '3' => 'dagger',
        };

        return new Player($name, $age, $weapon);
    }

    private function promptUntilValid(string $prompt, callable $validator, string $errorMessage): string
    {
        while (true) {
            $input = readline($prompt);
            if ($validator($input)) {
                return $input;
            }
            echo "{$errorMessage}\n";
        }
    }

    private function startAdventure(): void
    {
        echo "\n=== Adventure Begins ===\n";
        echo "Welcome, {$this->player->getName()}!\n\n";

        $this->encounterEnemy(new Enemy('Goblin', 50, 15));
    }

    private function encounterEnemy(Enemy $enemy): void
    {
        echo "A {$enemy->getName()} appears! (HP: {$enemy->getHealth()})\n";

        while ($this->player->isAlive() && $enemy->isAlive()) {
            $action = strtolower(readline("\n[A]ttack or [R]un? "));

            if ($action === 'a') {
                $this->combat($enemy);
            } elseif ($action === 'r') {
                echo "You ran away!\n";
                break;
            } else {
                echo "Invalid action!\n";
            }
        }

        if (!$this->player->isAlive()) {
            echo "\nGame Over!\n";
        }
    }

    private function combat(Enemy $enemy): void
    {
        $playerDamage = $this->player->attack();
        $enemy->takeDamage($playerDamage);
        echo "You dealt $playerDamage damage! Enemy HP: {$enemy->getHealth()}\n";

        if (!$enemy->isAlive()) {
            echo "You defeated the {$enemy->getName()}!\n";

            return;
        }

        $enemyDamage = $enemy->attack();
        $this->player->takeDamage($enemyDamage);
    }
}
