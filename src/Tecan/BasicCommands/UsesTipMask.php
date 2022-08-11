<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

interface UsesTipMask
{
    public function setTipMask(int $tipMask): void;
}
