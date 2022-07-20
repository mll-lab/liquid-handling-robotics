<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

final class Wash implements Command
{
    public static function commandLetter(): string
    {
        return 'W;';
    }

    public function toString(): string
    {
        return static::commandLetter();
    }
}
