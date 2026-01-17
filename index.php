<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Rpg\Player;

$name = readline('Enter your name: ');
$age = (int) readline('Age: ');
$weapon = readline('Weapon: ');

$player = new Player($name, $age, $weapon);

echo
    "Your name is {$player->getName()}. \n" .
    "Your age is {$player->getAge()}. \n" .
    "Your weapon is {$player->getWeapon()}. \n";
