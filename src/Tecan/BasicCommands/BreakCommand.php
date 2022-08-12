<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

final class BreakCommand extends Command
{
    public function toString(): string
    {
        return 'B;';
    }
}
