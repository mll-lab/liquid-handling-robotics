<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\CustomCommand;

use Illuminate\Support\Collection;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\AspirateAndDispenseParameters;
use Mll\LiquidHandlingRobotics\Tecan\Rack\Rack;

final class DispenseParameters
{
    public Rack $rack;

    /**
     * @var Collection<int, int>
     */
    public Collection $dispensePositions;

    /**
     * @param Collection<int, int> $dispensePositions
     */
    public function __construct(Rack $rack, Collection $dispensePositions)
    {
        $this->rack = $rack;
        $this->dispensePositions = $dispensePositions;
    }

    public function formatToAspirateAndDispenseParameters(): AspirateAndDispenseParameters
    {
        // use min and max of the dispense position as start and end.
        // Exclusion of the not excluded wells will happen in the calling class
        return new AspirateAndDispenseParameters(
            $this->rack,
            $this->dispensePositions->min(),
            $this->dispensePositions->max()
        );
    }
}
