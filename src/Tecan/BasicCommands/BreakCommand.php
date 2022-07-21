<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

final class BreakCommand implements Command
{
    public static function commandLetter(): string
    {
        return 'B;';
    }

    public function toString(): string
    {
        return static::commandLetter();
    }
}
