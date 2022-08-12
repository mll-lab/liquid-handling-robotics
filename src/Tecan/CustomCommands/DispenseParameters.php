<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\CustomCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\AspirateAndDispenseParameters;
use Mll\LiquidHandlingRobotics\Tecan\Rack\Rack;

final class DispenseParameters
{
    public Rack $rack;

    /**
     * @var array<int, int>
     */
    public array $dispensePositions;

    /**
     * @param array<int, int> $dispensePositions
     */
    public function __construct(Rack $rack, array $dispensePositions)
    {
        $this->rack = $rack;
        $this->dispensePositions = $dispensePositions;
    }

    public function formatToAspirateAndDispenseParameters(): AspirateAndDispenseParameters
    {
        // We use min and max of the dispense position as start and end.
        // Exclusion of the not excluded wells will happen in the calling class.
        $startPosition = min($this->dispensePositions);
        $endPosition = max($this->dispensePositions);
        assert(is_int($startPosition));
        assert(is_int($endPosition));

        return new AspirateAndDispenseParameters(
            $this->rack,
            $startPosition,
            $endPosition
        );
    }
}
