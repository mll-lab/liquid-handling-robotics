<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\FluidXPlate;

use Mll\Microplate\Coordinate;
use Mll\Microplate\CoordinateSystem96Well;
use Mll\Microplate\Microplate;

/**
 * @phpstan-extends Microplate<string, CoordinateSystem96Well>
 */
final class FluidXPlate extends Microplate
{
    public const FLUIDX_BARCODE_REGEX = /* @lang RegExp */ '/[A-Z]{2}(\d){8}/';

    public string $rackId;

    public function __construct(string $rackId)
    {
        if (0 === \Safe\preg_match(self::FLUIDX_BARCODE_REGEX, $rackId)) {
            throw new InvalidRackIdException($rackId);
        }
        $this->rackId = $rackId;

        parent::__construct(self::coordinateSystem());
    }

    public static function coordinateSystem(): CoordinateSystem96Well
    {
        return new CoordinateSystem96Well();
    }

    /**
     * @param Coordinate<CoordinateSystem96Well> $coordinate
     */
    public function addWell(Coordinate $coordinate, $barcode): void
    {
        if (0 === \Safe\preg_match(self::FLUIDX_BARCODE_REGEX, $barcode)) {
            throw new InvalidTubeBarcodeException($barcode);
        }

        parent::addWell($coordinate, $barcode);
    }
}
