<?php

declare(strict_types=1);

namespace Rpg\Console\Display;

use Rpg\Console\CustomStyle;
use Rpg\Enemy;
use Rpg\Player;

class GameDisplay
{
    public function __construct(private CustomStyle $io) {}

    public function showTitle(): void
    {
        $this->io->title('⚔️  RPG Adventure  ⚔️');
    }

    public function showCharacterCreationSection(): void
    {
        $this->io->section('Character Creation');
    }

    public function showWelcome(string $name, string $weapon): void
    {
        $this->io->text("You chose the $weapon!");
        $this->io->success("Welcome, $name the warrior!");
    }

    public function showAdventureBegins(string $weapon): void
    {
        $this->io->section('Adventure Begins');
        $this->io->text([
            'You venture into the dark forest...',
            "Your grip tightens on your $weapon...",
        ]);
    }

    public function showEnemyAppears(string $enemyName): void
    {
        $this->io->newLine();
        $this->io->warning("👹 A $enemyName appears!");
    }

    public function showPlayerAttack(int $damage): void
    {
        $this->io->text("<fg=green>⚔️  You dealt $damage damage!</>");
    }

    public function showEnemyAttack(string $enemyName, int $damage): void
    {
        $this->io->text("<fg=red>💥 The $enemyName dealt $damage damage!</>");
    }

    public function showVictory(string $enemyName): void
    {
        $this->io->success("🎉 Victory! You defeated the $enemyName!");
    }

    public function showGameOver(): void
    {
        $this->io->error('💀 Game Over! You have been defeated...');
    }

    public function showRanAway(): void
    {
        $this->io->note('You ran away to fight another day!');
    }

    public function showStats(Player $player, Enemy $enemy): void
    {
        $this->io->horizontalTable(
            ['Player HP', 'Enemy HP'],
            [[$this->getHealthBar($player->getHealth(), 100), $this->getHealthBar($enemy->getHealth(), 50)]]
        );
    }

    private function getHealthBar(int $current, int $max): string
    {
        $percentage = ($current / $max) * 100;
        $color = match (true) {
            $percentage > 60 => 'green',
            $percentage > 30 => 'yellow',
            default => 'red',
        };

        return "<fg=$color>$current/$max</>";
    }
}
