<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\FluidXPlate\Scalars;

use MLL\GraphQLScalars\Regex;
use Mll\LiquidHandlingRobotics\FluidXPlate\FluidXPlate;

final class FluidXBarcode extends Regex
{
    public $description = 'A valid barcode for FluidX-Tubes or FluidX-Plates represented as a string, e.g. `XR12345678`.';

    public static function regex(): string
    {
        return FluidXPlate::FLUIDX_BARCODE_REGEX;
    }
}
