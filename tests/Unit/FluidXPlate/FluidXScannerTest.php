<?php declare(strict_types=1);

namespace FluidXPlate;

use Mll\LiquidHandlingRobotics\FluidXPlate\FluidXScanner;
use PHPUnit\Framework\TestCase;

final class FluidXScannerTest extends TestCase
{
    public function testCreateFromStringEmpty(): void
    {
        $fluidXScanner = new FluidXScanner();
        $fluidXPlate = $fluidXScanner->scanPlate(FluidXScanner::TEST_IP);

        self::assertSame('SA00826894', $fluidXPlate->rackId);
        $collection = $fluidXPlate->filledWells();
        self::assertCount(3, $collection);
        self::assertSame('FD20024619', $collection->get('A1'));
        self::assertSame('FD20024698', $collection->get('A2'));
        self::assertSame('FD20024711', $collection->get('A3'));
    }
}
