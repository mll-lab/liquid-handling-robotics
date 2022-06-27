<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit;

use Mll\LiquidHandlingRobotics\FluidXPlate\FluidXPlate;
use Mll\LiquidHandlingRobotics\FluidXPlate\InvalidRackIdException;
use Mll\LiquidHandlingRobotics\FluidXPlate\InvalidTubeBarcodeException;
use Mll\Microplate\Coordinate;
use Mll\Microplate\CoordinateSystem96Well;
use PHPUnit\Framework\TestCase;
use TypeError;

final class FluidXPlateTest extends TestCase
{
    public function testCreateFromStringEmpty(): void
    {
        $rackId = '';
        $this->expectExceptionObject(new InvalidRackIdException($rackId));
        new FluidXPlate($rackId);
    }

    public function testCreateWithRandomNameAndReturnsIt(): void
    {
        $rackId = 'testInvalidRackId';
        $this->expectExceptionObject(new InvalidRackIdException($rackId));
        new FluidXPlate($rackId);
    }

    public function testCreatesSuccessfulWithValidBarCode(): void
    {
        $rackId = 'AB12345678';
        $fluidXPlate = new FluidXPlate($rackId);
        self::assertSame($rackId, $fluidXPlate->rackId);
        self::assertCount(96, $fluidXPlate->wells());
        self::assertCount(96, $fluidXPlate->freeWells());
        self::assertCount(0, $fluidXPlate->filledWells());
    }

    public function testCanNotAddInvalidBarcode(): void
    {
        $barcode = 'testWrongBarcode';
        $rackId = 'AB12345678';
        $fluidXPlate = new FluidXPlate($rackId);

        $this->expectExceptionObject(new InvalidTubeBarcodeException($barcode));
        $fluidXPlate->addWell(Coordinate::fromString('A1', new CoordinateSystem96Well()), $barcode);
    }

    public function testCanOnlyAddStringAsBarcode(): void
    {
        $rackId = 'AB12345678';
        $fluidXPlate = new FluidXPlate($rackId);

        $this->expectException(TypeError::class);
        // @phpstan-ignore-next-line expecting a type error due to and array as content paramenter
        $fluidXPlate->addWell(Coordinate::fromString('A1', new CoordinateSystem96Well()), []);
    }
}
