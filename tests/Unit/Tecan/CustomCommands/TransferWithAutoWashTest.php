<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tests\Unit\Tecan\CustomCommands;

use Mll\LiquidHandlingRobotics\Tecan\CustomCommands\TransferWithAutoWash;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\CustomLiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\Location\BarcodeLocation;
use Mll\LiquidHandlingRobotics\Tecan\Rack\CustomRack;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class TransferWithAutoWashTest extends TestCase
{
    public function testTransferWithAutoWashCommand(): void
    {
        $liquidClass = new CustomLiquidClass('TestLiquidClassName');
        $rack = new CustomRack('TestRackName', 'TestRackType');
        $aspirateLocation = new BarcodeLocation('barcode', $rack);
        $dispenseLocation = new BarcodeLocation('barcode1', $rack);

        $transfer = new TransferWithAutoWash(100, $liquidClass, $aspirateLocation, $dispenseLocation);

        self::assertSame(
            StringUtil::normalizeLineEndings(
                'A;;;TestRackType;;barcode;100;TestLiquidClassName;;
D;;;TestRackType;;barcode1;100;TestLiquidClassName;;
W;'
            ),
            $transfer->toString()
        );
    }
}
