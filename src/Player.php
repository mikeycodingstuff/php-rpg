<?php

namespace Rpg;

class Player
{
    public function __construct(
        protected string $name,
        protected int $age,
        protected string $weapon
    ) {}

    public function getName(): string
    {
        return $this->name;
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
