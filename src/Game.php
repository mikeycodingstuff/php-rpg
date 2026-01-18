<?php

declare(strict_types=1);

namespace Rpg;

use Rpg\Console\Display\GameDisplay;
use Rpg\Console\Prompts\GamePrompts;
use Symfony\Component\Console\Cursor;

class Game
{
    private Player $player;

    public function __construct(
        private GameDisplay $display,
        private GamePrompts $prompts,
        private Cursor $cursor,
    ) {}

    public function start(): void
    {
        $this->player = $this->createPlayer();

        if (!$this->prompts->confirmReady()) {
            return;
        }

        $this->startAdventure();
    }

    private function createPlayer(): Player
    {
        $this->display->showCharacterCreationSection();

        $name = $this->prompts->askName();
        $weapon = $this->prompts->chooseWeapon();

        $this->cursor->clearScreen();
        $this->display->showWelcome($name, $weapon);

        return new Player($name, $weapon);
    }

    private function startAdventure(): void
    {
        $this->display->showAdventureBegins($this->player->getWeapon());
        $this->encounterEnemy(new Enemy('Goblin', 50, 15));
    }

    private function encounterEnemy(Enemy $enemy): void
    {
        $this->display->showEnemyAppears($enemy->getName());
        $this->display->showStats($this->player, $enemy);

        while ($this->player->isAlive() && $enemy->isAlive()) {
            $action = $this->prompts->chooseCombatAction();

            if ($action === 'attack') {
                $this->combat($enemy);
            } else {
                $this->display->showRanAway();
                break;
            }
        }

        if (!$this->player->isAlive()) {
            $this->display->showGameOver();
        }
    }

    private function combat(Enemy $enemy): void
    {
        // Player attacks
        $playerDamage = $this->player->attack();
        $enemy->takeDamage($playerDamage);
        $this->display->showPlayerAttack($playerDamage);

        if (!$enemy->isAlive()) {
            $this->display->showVictory($enemy->getName());

            return;
        }

        // Enemy attacks
        $enemyDamage = $enemy->attack();
        $this->player->takeDamage($enemyDamage);
        $this->display->showEnemyAttack($enemy->getName(), $enemyDamage);

        $this->display->showStats($this->player, $enemy);
    }
}
