<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

final class Wash implements Command
{
    public function formatToString(): string
    {
        return 'W;';
    }
}
