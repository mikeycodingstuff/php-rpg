<?php

declare(strict_types=1);

namespace Rpg\Traits;

trait CanAttack
{
    public function attack(): int
    {
        return rand(1, $this->attackPower);
    }
}
