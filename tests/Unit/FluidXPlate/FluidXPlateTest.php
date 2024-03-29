<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\FluidXPlate;

use Mll\LiquidHandlingRobotics\FluidXPlate\FluidXPlate;
use Mll\LiquidHandlingRobotics\FluidXPlate\InvalidRackIdException;
use Mll\LiquidHandlingRobotics\FluidXPlate\InvalidTubeBarcodeException;
use Mll\Microplate\Coordinates;
use Mll\Microplate\CoordinateSystem96Well;
use Mll\Microplate\Enums\FlowDirection;
use PHPUnit\Framework\TestCase;

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
        $coordinates = Coordinates::fromString('A1', new CoordinateSystem96Well());

        $this->expectExceptionObject(new InvalidTubeBarcodeException($barcode));
        $fluidXPlate->addWell($coordinates, $barcode);
    }

    public function testCanOnlyAddStringAsBarcode(): void
    {
        $rackId = 'AB12345678';
        $fluidXPlate = new FluidXPlate($rackId);
        $coordinates = Coordinates::fromString('A1', new CoordinateSystem96Well());

        $this->expectException(\TypeError::class);
        // @phpstan-ignore-next-line intentionally wrong
        $fluidXPlate->addWell($coordinates, []);
    }

    public function testCanAddToNextFreeWell(): void
    {
        $rackId = 'AB12345678';
        $fluidXPlate = new FluidXPlate($rackId);
        $expectedCoordinates = Coordinates::fromString('A1', new CoordinateSystem96Well());
        $addToNextFreeWell = $fluidXPlate->addToNextFreeWell('test', FlowDirection::COLUMN());
        self::assertEquals($expectedCoordinates, $addToNextFreeWell);
    }
}
