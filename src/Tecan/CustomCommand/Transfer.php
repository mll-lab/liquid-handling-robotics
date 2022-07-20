<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\CustomCommand;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Dispense;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\PipettingActionCommand;
use Mll\LiquidHandlingRobotics\Tecan\TecanProtocol;

class Transfer implements PipettingActionCommand
{
    private Aspirate $aspirate;

    private Dispense $dispense;

    public function __construct(Aspirate $aspirate, Dispense $dispense)
    {
        $this->aspirate = $aspirate;
        $this->dispense = $dispense;
    }

    public static function commandLetter(): string
    {
        return 'W;';
    }

    public function toString(): string
    {
        return
            $this->aspirate->toString()
            . TecanProtocol::WINDOWS_NEW_LINE
            . $this->dispense->toString()
            . TecanProtocol::WINDOWS_NEW_LINE
            . static::commandLetter();
    }

    public function setTipMask(int $tipMask): void
    {
        $this->aspirate->setTipMask($tipMask);
        $this->dispense->setTipMask($tipMask);
    }
}
