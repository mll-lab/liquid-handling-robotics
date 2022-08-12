<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

abstract class Command
{
    /**
     * Serializes the command-class to a pipetting instruction according the gwl file format.
     */
    abstract public function toString(): string;
}
