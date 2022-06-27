<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\FluidXPlate;

class InvalidTubeBarcodeException extends FluidXPlateException
{
    public function __construct(string $tubeBarcode)
    {
        parent::__construct("Invalid tube barcode: {$tubeBarcode}");
    }
}
