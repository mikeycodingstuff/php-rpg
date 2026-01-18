<?php

declare(strict_types=1);

namespace Rpg\Traits;

trait HasHealth
{
    public function getHealth(): int
    {
        return $this->health;
    }

    public function isAlive(): bool
    {
        return $this->health > 0;
    }

    public function takeDamage(int $damage): void
    {
        $this->health -= $damage;
    }
}
