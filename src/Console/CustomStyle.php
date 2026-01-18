<?php

declare(strict_types=1);

namespace Rpg\Console;

use Symfony\Component\Console\Style\SymfonyStyle;

class CustomStyle extends SymfonyStyle
{
    public function info(string|array $message): void
    {
        $this->block($message, null, 'fg=green', ' ', true);
    }

    public function success(string|array $message): void
    {
        $this->block($message, null, 'fg=black;bg=green', ' ', true);
    }
}
