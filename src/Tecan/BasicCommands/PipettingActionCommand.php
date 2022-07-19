<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

interface PipettingActionCommand extends Command
{
    public function setTipMask(int $tipMask): void;
}
