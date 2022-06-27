<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\FluidXPlate;

final class InvalidRackIdException extends FluidXPlateException
{
    public function __construct(string $rackId)
    {
        parent::__construct("Invalid rack ID: {$rackId}");
    }
}
