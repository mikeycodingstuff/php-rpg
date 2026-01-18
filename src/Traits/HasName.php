<?php

declare(strict_types=1);

namespace Rpg\Traits;

trait HasName
{
    public function getName(): string
    {
        return $this->name;
    }
}
