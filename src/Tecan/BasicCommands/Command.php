<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

interface Command
{
    public static function commandLetter(): string;

    public function toString(): string;
}
