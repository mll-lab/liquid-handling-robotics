<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

abstract class Command
{
    abstract public function toString(): string;
}
