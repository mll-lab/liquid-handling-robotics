<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\CustomCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Command;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Dispense;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\UsesTipMask;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Wash;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\LiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\Location;
use Mll\LiquidHandlingRobotics\Tecan\TecanProtocol;

final class TransferWithAutoWash extends Command implements UsesTipMask
{
    private Aspirate $aspirate;

    private Dispense $dispense;

    public function __construct(float $volume, LiquidClass $liquidClass, Location $aspirateLocation, Location $dispenseLocation)
    {
        $this->aspirate = new Aspirate($volume, $aspirateLocation, $liquidClass);
        $this->dispense = new Dispense($volume, $dispenseLocation, $liquidClass);
    }

    public function toString(): string
    {
        return implode(TecanProtocol::WINDOWS_NEW_LINE, [
            $this->aspirate->toString(),
            $this->dispense->toString(),
            (new Wash())->toString(),
        ]);
    }

    public function setTipMask(int $tipMask): void
    {
        $this->aspirate->setTipMask($tipMask);
        $this->dispense->setTipMask($tipMask);
    }
}
