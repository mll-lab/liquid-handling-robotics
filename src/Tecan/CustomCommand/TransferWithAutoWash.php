<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\CustomCommand;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Dispense;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\PipettingActionCommand;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Wash;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\LiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\Location;
use Mll\LiquidHandlingRobotics\Tecan\TecanProtocol;

final class TransferWithAutoWash implements PipettingActionCommand
{
    private Aspirate $aspirate;

    private Dispense $dispense;

    public function __construct(float $volume, LiquidClass $liquidClass, Location $aspirateLocation, Location $dispenseLocation)
    {
        $this->aspirate = new Aspirate($volume, $aspirateLocation, $liquidClass);
        $this->dispense = new Dispense($volume, $dispenseLocation, $liquidClass);
    }

    public function formatToString(): string
    {
        return
            $this->aspirate->formatToString()
            . TecanProtocol::WINDOWS_NEW_LINE
            . $this->dispense->formatToString()
            . TecanProtocol::WINDOWS_NEW_LINE
            . (new Wash())->formatToString();
    }

    public function setTipMask(int $tipMask): void
    {
        $this->aspirate->setTipMask($tipMask);
        $this->dispense->setTipMask($tipMask);
    }
}
