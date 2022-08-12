<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\LiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\Location;

final class Aspirate extends BasicPipettingActionCommand
{
    /**
     * @param float $volume Floating point values are accepted and do not cause an error,
     * but they will be rounded before being used. In such cases, it is recommended to use
     * integer calculations to avoid unexpected results.
     */
    public function __construct(float $volume, Location $location, LiquidClass $liquidClass)
    {
        $this->volume = $volume;
        $this->location = $location;
        $this->liquidClass = $liquidClass;
    }

    public static function commandLetter(): string
    {
        return 'A';
    }
}
