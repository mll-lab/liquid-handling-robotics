<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\Rack\Rack;

final class AspirateAndDispenseParameters
{
    private Rack $rack;

    private int $startPosition;

    private int $endPosition;

    public function __construct(Rack $rack, int $startPosition, int $endPosition)
    {
        $this->rack = $rack;
        $this->startPosition = $startPosition;
        $this->endPosition = $endPosition;
    }

    public function formatToString(): string
    {
        return implode(
            ';',
            [
                $this->rack->toString(),
                $this->startPosition,
                $this->endPosition,
            ]
        );
    }
}
