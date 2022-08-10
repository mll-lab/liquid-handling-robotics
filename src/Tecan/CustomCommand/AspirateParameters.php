<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\CustomCommand;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\AspirateAndDispenseParameters;
use Mll\LiquidHandlingRobotics\Tecan\Rack\Rack;

final class AspirateParameters
{
    private Rack $rack;

    private int $sourcePosition;

    public function __construct(Rack $rack, int $sourcePosition)
    {
        $this->rack = $rack;
        $this->sourcePosition = $sourcePosition;
    }

    public function formatToAspirateAndDispenseParameters(): AspirateAndDispenseParameters
    {
        // this class uses $sourcePosition as startPosition and endPosition for simplification
        return new AspirateAndDispenseParameters(
            $this->rack,
            $this->sourcePosition,
            $this->sourcePosition
        );
    }
}
