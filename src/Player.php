<?php

declare(strict_types=1);

namespace Rpg;

use Rpg\Traits\CanAttack;
use Rpg\Traits\HasHealth;
use Rpg\Traits\HasName;

class Player
{
    use CanAttack, HasHealth, HasName;

    protected int $health = 100;

    protected int $attackPower;

    public function __construct(
        protected string $name,
        protected int $age,
        protected string $weapon,
    ) {
        $this->attackPower = match ($weapon) {
            'sword' => 20,
            'axe' => 25,
            'dagger' => 15,
            default => 1,
        };
    }

    public function takeDamage(int $damage): void
    {
        $this->health -= $damage;
        echo "You took $damage damage! Health: $this->health\n";
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getWeapon(): string
    {
        return $this->weapon;
    }
}
