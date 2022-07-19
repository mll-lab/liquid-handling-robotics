<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\Location\BarcodeLocation;
use Mll\LiquidHandlingRobotics\Tecan\Location\PositionLocation;
use Mll\LiquidHandlingRobotics\Tests\TestImplentations\TestLiquidClass;
use Mll\LiquidHandlingRobotics\Tests\TestImplentations\TestRack;
use PHPUnit\Framework\TestCase;

class AspirateTest extends TestCase
{
    public function testAspirateWithBarcodeLocation(): void
    {
        $barcode = 'barcode';
        $aspirate = new Aspirate(100, new BarcodeLocation($barcode, new TestRack()), new TestLiquidClass());
        self::assertSame($barcode, $aspirate->location->tubeId());
        self::assertSame('', $aspirate->location->position());
        self::assertSame('A;TestRackName;;TestRackType;;barcode;100;TestLiquidClassName;;;', $aspirate->toString());
    }

    public function testAspirateWithLabelLocation(): void
    {
        $position = 7;
        $aspirate = new Aspirate(100, new PositionLocation($position, new TestRack()), new TestLiquidClass());
        self::assertSame('', $aspirate->location->tubeId());
        self::assertSame((string) $position, $aspirate->location->position());
        self::assertSame('A;;;TestRackType;7;;100;TestLiquidClassName;;;', $aspirate->toString());
    }
}
