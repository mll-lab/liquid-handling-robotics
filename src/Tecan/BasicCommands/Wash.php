<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

final class Wash extends Command
{
    public function toString(): string
    {
        return 'W;';
    }
}
