<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan\BasicCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Dispense;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\CustomLiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\MllLiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\BarcodeLocation;
use Mll\LiquidHandlingRobotics\Tecan\Location\PositionLocation;
use Mll\LiquidHandlingRobotics\Tecan\Rack\CustomRack;
use Mll\LiquidHandlingRobotics\Tecan\Rack\MllLabWareRack;
use PHPUnit\Framework\TestCase;

final class DispenseTest extends TestCase
{
    public function testDispenseWithBarcodeLocation(): void
    {
        $barcode = 'barcode';
        $aspirate = new Dispense(100, new BarcodeLocation($barcode, new CustomRack('TestRackName', 'TestRackType')), new CustomLiquidClass('TestLiquidClassName'));
        self::assertSame($barcode, $aspirate->location->tubeId());
        self::assertNull($aspirate->location->position());
        self::assertSame('D;;;TestRackType;;barcode;100;TestLiquidClassName;;', $aspirate->toString());
    }

    public function testDispenseWithPositionLocation(): void
    {
        $position = 7;
        $volume = 2.2;
        $aspirate = new Dispense($volume, new PositionLocation($position, MllLabWareRack::DEST_LC()), MllLiquidClass::TRANSFER_TEMPLATE());
        self::assertNull($aspirate->location->tubeId());
        self::assertSame((string) $position, $aspirate->location->position());
        self::assertSame("D;DestLC;;96 Well MP LightCycler480;{$position};;{$volume};Transfer_Template;;", $aspirate->toString());
    }
}
