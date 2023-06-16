<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\FluidXPlate;

use Illuminate\Support\Collection;
use Mll\Microplate\Coordinates;
use Mll\Microplate\CoordinateSystem96Well;
use Mll\Microplate\Enums\FlowDirection;
use Mll\Microplate\Microplate;

final class FluidXPlate
{
    public const FLUIDX_BARCODE_REGEX = /* @lang RegExp */ '/' . self::FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER . '/';
    public const FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER = '[A-Z]{2}(\d){8}';

    public string $rackId;

    /**
     * @var Microplate<string, CoordinateSystem96Well>
     */
    private Microplate $microplate;

    public function __construct(string $rackId)
    {
        if (0 === \Safe\preg_match(self::FLUIDX_BARCODE_REGEX, $rackId)) {
            throw new InvalidRackIdException($rackId);
        }
        $this->rackId = $rackId;
        $this->microplate = new Microplate(self::coordinateSystem());
    }

    public static function coordinateSystem(): CoordinateSystem96Well
    {
        return new CoordinateSystem96Well();
    }

    /**
     * @param Coordinates<CoordinateSystem96Well> $coordinates
     */
    public function addWell(Coordinates $coordinates, string $barcode): void
    {
        if (0 === \Safe\preg_match(self::FLUIDX_BARCODE_REGEX, $barcode)) {
            throw new InvalidTubeBarcodeException($barcode);
        }

        $this->microplate->addWell($coordinates, $barcode);
    }

    /**
     * @return Coordinates<CoordinateSystem96Well>
     */
    public function addToNextFreeWell(string $content, FlowDirection $flowDirection): Coordinates
    {
        return $this->microplate->addToNextFreeWell($content, $flowDirection);
    }

    /**
     * @return Collection<string, string|null>
     */
    public function wells(): Collection
    {
        return $this->microplate->wells();
    }

    /**
     * @return Collection<string, null>
     */
    public function freeWells(): Collection
    {
        return $this->microplate->freeWells();
    }

    /**
     * @return Collection<string, string>
     */
    public function filledWells(): Collection
    {
        return $this->microplate->filledWells();
    }
}
