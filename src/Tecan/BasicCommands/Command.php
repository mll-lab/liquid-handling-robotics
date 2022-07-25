<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

interface Command
{
    public function formatToString(): string;
}
