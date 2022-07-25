<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Aspirate;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\CustomLiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\MllLiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\BarcodeLocation;
use Mll\LiquidHandlingRobotics\Tecan\Location\PositionLocation;
use Mll\LiquidHandlingRobotics\Tecan\Rack\CustomRack;
use Mll\LiquidHandlingRobotics\Tecan\Rack\MllLabWareRack;
use PHPUnit\Framework\TestCase;

final class AspirateTest extends TestCase
{
    public function testAspirateWithBarcodeLocation(): void
    {
        $barcode = 'barcode';
        $aspirate = new Aspirate(100, new BarcodeLocation($barcode, new CustomRack('TestRackName', 'TestRackType')), new CustomLiquidClass('TestLiquidClassName'));
        self::assertSame($barcode, $aspirate->location->tubeId());
        self::assertNull($aspirate->location->position());
        self::assertSame('A;;;TestRackType;;barcode;100;TestLiquidClassName;;', $aspirate->formatToString());
    }

    public function testAspirateWithPositionLocation(): void
    {
        $position = 7;
        $volume = 2.2;
        $aspirate = new Aspirate($volume, new PositionLocation($position, MllLabWareRack::DEST_PCR()), MllLiquidClass::TRANSFER_TEMPLATE());
        self::assertNull($aspirate->location->tubeId());
        self::assertSame((string) $position, $aspirate->location->position());
        self::assertSame('A;DestPCR;;96 Well PCR ABI semi-skirted;' . $position . ';;2.2;Transfer_Template;;', $aspirate->formatToString());
    }
}
