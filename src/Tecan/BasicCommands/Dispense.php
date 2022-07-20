<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\LiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\Location;

final class Dispense extends BasicPipettingActionCommand implements Command
{
    public function __construct(int $volume, Location $location, LiquidClass $liquidClass)
    {
        $this->volume = $volume;
        $this->location = $location;
        $this->liquidClass = $liquidClass;
    }

    public static function commandLetter(): string
    {
        return 'D';
    }
}
