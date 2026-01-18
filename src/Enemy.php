<?php

declare(strict_types=1);

namespace Rpg;

use Rpg\Traits\CanAttack;
use Rpg\Traits\HasHealth;
use Rpg\Traits\HasName;

class Enemy
{
    use CanAttack, HasHealth, HasName;

    public function __construct(
        protected string $name,
        protected int $health,
        protected int $attackPower,
    ) {}
}
